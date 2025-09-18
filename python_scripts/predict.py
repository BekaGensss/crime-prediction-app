# crime-prediction-app/python_scripts/predict.py

import pandas as pd
from sklearn.model_selection import train_test_split
from sklearn.ensemble import RandomForestClassifier
from sklearn.tree import DecisionTreeClassifier
from sklearn.linear_model import LogisticRegression, LinearRegression
from sklearn.svm import SVC
from sklearn.metrics import accuracy_score
import joblib
from flask import Flask, request, jsonify
import os
import numpy as np

app = Flask(__name__)

# --- Load dan Pre-processing Data ---
def load_and_prepare_data(file_path):
    if not os.path.exists(file_path):
        raise FileNotFoundError(f"Error: File {file_path} tidak ditemukan.")
    
    df = pd.read_csv(file_path)

    df.rename(columns={
        'Kepolisian Daerah': 'lokasi',
        'Jumlah Tindak Pidana 2021': 'jumlah_2021',
        'Jumlah Tindak Pidana 2022': 'jumlah_2022'
    }, inplace=True)
    
    df = df[df['lokasi'] != 'INDONESIA'].copy()

    df['jumlah_2021'] = pd.to_numeric(df['jumlah_2021'].astype(str).str.replace(',', ''), errors='coerce')
    df['jumlah_2022'] = pd.to_numeric(df['jumlah_2022'].astype(str).str.replace(',', ''), errors='coerce')

    df['total_jumlah'] = df['jumlah_2021'] + df['jumlah_2022']
    
    bins = [df['total_jumlah'].min() - 1, df['total_jumlah'].quantile(0.5), df['total_jumlah'].max()]
    labels = ['Rendah', 'Tinggi']
    df['tingkat_resiko'] = pd.cut(df['total_jumlah'], bins=bins, labels=labels)
    
    df = pd.get_dummies(df, columns=['lokasi'])
    
    return df

# --- Melatih Model dan Menyimpan File ---
def train_and_save_models(df):
    X = df.drop(['jumlah_2021', 'jumlah_2022', 'total_jumlah', 'tingkat_resiko', 'Penyelesaian tindak pidana 2021(%)', 'Penyelesaian tindak pidana 2022(%)'], axis=1, errors='ignore')
    y_clf = df['tingkat_resiko']
    
    global location_columns
    location_columns = X.columns.tolist()
    
    X_train, X_test, y_train_clf, y_test_clf = train_test_split(X, y_clf, test_size=0.2, random_state=42)
    
    # Random Forest Classifier
    rf_model = RandomForestClassifier(n_estimators=100, random_state=42)
    rf_model.fit(X_train, y_train_clf)
    joblib.dump(rf_model, 'rf_model.pkl')
    rf_accuracy = accuracy_score(y_test_clf, rf_model.predict(X_test))
    joblib.dump(rf_accuracy, 'rf_accuracy.pkl')
    
    # Decision Tree Classifier
    dt_model = DecisionTreeClassifier(max_depth=3, random_state=42)
    dt_model.fit(X_train, y_train_clf)
    joblib.dump(dt_model, 'dt_model.pkl')
    dt_accuracy = accuracy_score(y_test_clf, dt_model.predict(X_test))
    joblib.dump(dt_accuracy, 'dt_accuracy.pkl')

    # Logistic Regression
    lr_model = LogisticRegression(random_state=42)
    lr_model.fit(X_train, y_train_clf)
    joblib.dump(lr_model, 'lr_model.pkl')
    lr_accuracy = accuracy_score(y_test_clf, lr_model.predict(X_test))
    joblib.dump(lr_accuracy, 'lr_accuracy.pkl')

    # Support Vector Machine (SVM)
    svm_model = SVC(probability=True, random_state=42)
    svm_model.fit(X_train, y_train_clf)
    joblib.dump(svm_model, 'svm_model.pkl')
    svm_accuracy = accuracy_score(y_test_clf, svm_model.predict(X_test))
    joblib.dump(svm_accuracy, 'svm_accuracy.pkl')
    
    print("Models trained and saved successfully.")
    
# --- Jalankan Proses ---
try:
    data = load_and_prepare_data('crime_data.csv') 
    train_and_save_models(data)
except FileNotFoundError as e:
    print(e)
except Exception as e:
    print(f"Terjadi kesalahan saat memproses data: {e}")

# --- API endpoint untuk Prediksi Klasifikasi ---
@app.route('/predict', methods=['POST'])
def predict():
    try:
        data = request.get_json()
        lokasi = data['lokasi']
        model_name = data.get('model', 'rf') 

        if model_name == 'dt':
            model = joblib.load('dt_model.pkl')
        elif model_name == 'lr':
            model = joblib.load('lr_model.pkl')
        elif model_name == 'svm':
            model = joblib.load('svm_model.pkl')
        else:
            model = joblib.load('rf_model.pkl')
        
        input_df = pd.DataFrame(columns=location_columns)
        input_df.loc[0] = 0
        
        location_col_name = f'lokasi_{lokasi}'
        if location_col_name in input_df.columns:
            input_df.loc[0, location_col_name] = 1
        else:
            return jsonify({'error': 'Lokasi tidak ditemukan dalam data pelatihan.'}), 400
        
        prediction = model.predict(input_df)
        probabilities = model.predict_proba(input_df)[0].tolist()
        
        return jsonify({
            'prediksi': prediction[0],
            'probabilitas': probabilities
        })
        
    except Exception as e:
        return jsonify({'error': str(e)}), 500

# --- API endpoint untuk Prediksi Peramalan ---
@app.route('/forecast', methods=['POST'])
def forecast():
    try:
        data = request.get_json()
        lokasi = data['lokasi']
        
        df_full = pd.read_csv('crime_data.csv')
        df_full.rename(columns={
            'Kepolisian Daerah': 'lokasi',
            'Jumlah Tindak Pidana 2021': 'jumlah_2021',
            'Jumlah Tindak Pidana 2022': 'jumlah_2022'
        }, inplace=True)
        
        df_full = df_full[df_full['lokasi'] == lokasi].copy()

        if df_full.empty:
            return jsonify({'error': 'Data lokasi tidak ditemukan untuk peramalan.'}), 400
        
        jumlah_2021 = pd.to_numeric(df_full.iloc[0]['jumlah_2021'], errors='coerce')
        jumlah_2022 = pd.to_numeric(df_full.iloc[0]['jumlah_2022'], errors='coerce')
        
        if pd.isna(jumlah_2021) or pd.isna(jumlah_2022):
             return jsonify({'error': 'Data jumlah kejahatan untuk tahun 2021 atau 2022 tidak valid.'}), 400

        X = [[2021], [2022]]
        y = [jumlah_2021, jumlah_2022]

        reg_model = LinearRegression()
        reg_model.fit(X, y)
        
        # PERBAIKAN: Memprediksi untuk tahun 2023, 2024, 2025, dan 2026
        forecast_years = [2023, 2024, 2025, 2026]
        forecasts = [int(reg_model.predict([[year]])[0]) for year in forecast_years]

        return jsonify({
            'lokasi': lokasi,
            'data_2021': int(jumlah_2021),
            'data_2022': int(jumlah_2022),
            'forecasts': forecasts, # Mengirimkan daftar peramalan
            'forecast_years': forecast_years # Mengirimkan daftar tahun peramalan
        })
        
    except Exception as e:
        return jsonify({'error': str(e)}), 500
        
# Endpoint baru untuk membandingkan model
@app.route('/compare-models')
def compare_models():
    try:
        rf_accuracy = joblib.load('rf_accuracy.pkl')
        dt_accuracy = joblib.load('dt_accuracy.pkl')
        lr_accuracy = joblib.load('lr_accuracy.pkl')
        svm_accuracy = joblib.load('svm_accuracy.pkl')
        
        return jsonify({
            'rf_accuracy': round(rf_accuracy * 100, 2),
            'dt_accuracy': round(dt_accuracy * 100, 2),
            'lr_accuracy': round(lr_accuracy * 100, 2),
            'svm_accuracy': round(svm_accuracy * 100, 2)
        })
    except Exception as e:
        return jsonify({'error': str(e)}), 500

if __name__ == '__main__':
    app.run(host='127.0.0.1', port=5000)