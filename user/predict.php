<?php
function predictCoralHealth($imagePath) {
    $url = 'http://localhost:5000/predict';
    $cFile = curl_file_create($imagePath, mime_content_type($imagePath), basename($imagePath));

    $data = array('image' => $cFile);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $imageTmpPath = $_FILES['image']['tmp_name'];
    $result = predictCoralHealth($imageTmpPath);

    if (isset($result['prediction']) && isset($result['image_path'])) {
        $prediction = $result['prediction'];
        $imagePath = $result['image_path'];
        header('Location: gambar.php?prediction=' . urlencode($prediction) . '&image_path=' . urlencode($imagePath));
    } else {
        header('Location: gambar.php?prediction=Gagal melakukan prediksi');
    }
} else {
    echo "Tidak ada gambar yang diunggah.";
}
?>
