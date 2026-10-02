<?php
$nama = $no_wa = $email = $matkul = $motivasi = "";
$errors = [];
$is_submitted = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nama     = trim($_POST['nama'] ?? '');
    $no_wa    = trim($_POST['no_wa'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $matkul   = trim($_POST['matkul'] ?? '');
    $motivasi = trim($_POST['motivasi'] ?? '');

    if (empty($nama) || empty($no_wa) || empty($email) || empty($matkul) || empty($motivasi)) {
        $errors[] = "Pendaftaran gagal! Harap penuhi data yang sisa.";
    } else {
        if (!preg_match("/^[a-zA-Z\s]+$/", $nama)) {
            $errors[] = "Nama lengkap harus berupa huruf!";
        }

        if (!preg_match("/^(0|62)[0-9]+$/", $no_wa)) {
            $errors[] = "Nomor WhatsApp harus diawali angka '0' atau '62'!";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Email institusi berformat tidak valid!";
        }
    }

    if (empty($errors)) {
        $is_submitted = true;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Asisten Praktikum</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="card">
        
        <div class="header">
            <h1><?php echo $is_submitted ? "Kartu Registrasi" : "Pendaftaran Asisten Praktikum"; ?></h1>
            <p>Laboratorium Enterprise Application Development</p>
        </div>

        <?php if (!empty($errors)): ?>
            <div class="alert-error">
                <p><strong>Pendaftaran gagal!</strong> Harap penuhi data yang sisa.</p>
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if ($is_submitted): ?>
            
            <div class="card-registrasi">
                <div class="info-row">
                    <div class="info-label">Nama Lengkap</div>
                    <div class="info-value">: <?php echo htmlspecialchars($nama); ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">No. WhatsApp</div>
                    <div class="info-value">: <?php echo htmlspecialchars($no_wa); ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Email Institusi</div>
                    <div class="info-value">: <?php echo htmlspecialchars($email); ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Mata Kuliah</div>
                    <div class="info-value">: <?php echo htmlspecialchars($matkul); ?></div>
                </div>
                <div class="motivasi-box">
                    <div class="info-label">Motivasi</div>
                    <div class="motivasi-text"><?php echo nl2br(htmlspecialchars($motivasi)); ?></div>
                </div>
            </div>

            <a href="soal.php" class="btn-primary">Kembali ke Form</a>

        <?php else: ?>

            <form action="soal.php" method="POST" novalidate>
                
                <div class="form-group">
                    <label>Nama Lengkap *</label>
                    <input type="text" name="nama" value="<?php echo htmlspecialchars($nama); ?>" placeholder="Masukkan nama lengkap" class="form-control">
                </div>

                <div class="form-group">
                    <label>Nomor WhatsApp *</label>
                    <input type="text" name="no_wa" value="<?php echo htmlspecialchars($no_wa); ?>" placeholder="Contoh: 08123456789" class="form-control">
                </div>

                <div class="form-group">
                    <label>Email Institusi *</label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" placeholder="nama@student.telkomuniversity.ac.id" class="form-control">
                </div>

                <div class="form-group">
                    <label>Pilihan Mata Kuliah Praktikum *</label>
                    <select name="matkul" class="form-control">
                        <option value="">-- Pilih Mata Kuliah --</option>
                        <option value="Pengembangan Aplikasi Website" <?php echo ($matkul === "Pengembangan Aplikasi Website") ? "selected" : ""; ?>>Pengembangan Aplikasi Website</option>
                        <option value="Pemrograman Berbasis Objek" <?php echo ($matkul === "Pemrograman Berbasis Objek") ? "selected" : ""; ?>>Pemrograman Berbasis Objek</option>
                        <option value="Basics Data" <?php echo ($matkul === "Basics Data") ? "selected" : ""; ?>>Basics Data</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Motivasi Mendaftar *</label>
                    <textarea name="motivasi" rows="3" placeholder="Tuliskan alasan Anda mendaftar..." class="form-control"><?php echo htmlspecialchars($motivasi); ?></textarea>
                </div>

                <button type="submit" class="btn-primary">Daftar Sekarang</button>
                <a href="soal.php" class="btn-secondary">Lihat Data Pendaftar</a>

            </form>

        <?php endif; ?>

    </div>

</body>
</html>