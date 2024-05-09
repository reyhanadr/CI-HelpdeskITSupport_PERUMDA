<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Svm_lib {

    public function train($trainingData, $labels)
    {
        // Gantilah dengan lokasi absolut dari svm-train yang sesuai dengan instalasi LibSVM Anda.
        $svmTrain = APPPATH . 'third_party/libsvm/svm-train';

        // Buat file training data dari array
        $trainingFile = tempnam(sys_get_temp_dir(), 'training_data');
        file_put_contents($trainingFile, $this->formatTrainingData($trainingData, $labels));

        // Model file
        $modelFile = tempnam(sys_get_temp_dir(), 'model');

        // Training SVM model
        exec("$svmTrain -s 0 -t 0 $trainingFile $modelFile");

        // Simpan model ke file jika diperlukan
        return file_get_contents($modelFile);
    }

    public function predict($model, $features)
    {
        // Gantilah dengan lokasi absolut dari svm-predict yang sesuai dengan instalasi LibSVM Anda.
        $svmPredict = APPPATH . 'third_party/libsvm/svm-predict';

        // Simpan model ke file
        $modelFile = tempnam(sys_get_temp_dir(), 'model');
        file_put_contents($modelFile, $model);

        // Buat file input dari array
        $inputFile = tempnam(sys_get_temp_dir(), 'input');
        file_put_contents($inputFile, $this->formatFeatureData($features));

        // Output file
        $outputFile = tempnam(sys_get_temp_dir(), 'output');

        // Prediksi dengan SVM model
        exec("$svmPredict $inputFile $modelFile $outputFile");

        // Baca hasil prediksi dari file output
        $predictedPriority = file_get_contents($outputFile);

        return trim($predictedPriority);
    }

    private function formatTrainingData($trainingData, $labels)
    {
        $formattedData = '';
        foreach ($trainingData as $index => $data) {
            $formattedData .= $labels[$index] . ' ' . $this->formatFeatureData($data) . PHP_EOL;
        }
        return $formattedData;
    }

    private function formatFeatureData($features)
    {
        $formattedFeatures = '';
        foreach ($features as $key => $value) {
            $formattedFeatures .= "$key:$value ";
        }
        return trim($formattedFeatures);
    }
    public function saveModel($modelName, $modelData)
    {
        // Path untuk menyimpan model
        $modelPath = APPPATH . 'models/' . $modelName;
    
        // Simpan model ke dalam file
        file_put_contents($modelPath, $modelData);
    
        // Pastikan model telah disimpan dengan sukses
        if (file_exists($modelPath)) {
            return true; // Model berhasil disimpan
        } else {
            return false; // Gagal menyimpan model
        }
    }
    

    public function loadModel($modelName)
    {
        // Path untuk memuat model
        $modelPath = APPPATH . 'models/' . $modelName;
    
        // Memeriksa apakah file model ada
        if (file_exists($modelPath)) {
            // Membaca isi file model
            $modelData = file_get_contents($modelPath);
            return $modelData; // Mengembalikan data model yang dimuat
        } else {
            return false; // File model tidak ditemukan
        }
    }
    
}
