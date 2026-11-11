
<?php
$data = null;
$error = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nama = trim($_POST["nama"] ?? "");
    $nim = trim($_POST["nim"] ?? "");
    $prodi = trim($_POST["prodi"] ?? "");
    $semesterInput = $_POST["semester"] ?? "";
    $email = trim($_POST["email"] ?? "");

    // Validasi nama, NIM, dan program studi
    if ($nama === "") {
        $error[] = "Nama wajib diisi.";
    }

    if ($nim === "") {
        $error[] = "NIM wajib diisi.";
    }

    if ($prodi === "") {
        $error[] = "Program studi wajib diisi.";
    }

    // Validasi email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error[] = "Format email tidak valid.";
    }

    // Validasi semester
    if (
        !ctype_digit((string)$semesterInput) ||
        (int)$semesterInput < 1 ||
        (int)$semesterInput > 14
    ) {
        $error[] = "Semester harus berupa angka 1-14.";
    }

    // Jika semua data valid
    if (!$error) {
        $data = compact("nama", "nim", "prodi", "email");
        $data["semester"] = (int)$semesterInput;
    }
}
?>

<h2>Formulir Data Mahasiswa</h2>

<form method="POST">

    <label>Nama:</label><br>
    <input type="text" name="nama" required>
    <br><br>

    <label>NIM:</label><br>
    <input type="text" name="nim" required>
    <br><br>

    <label>Program Studi:</label><br>
    <input type="text" name="prodi" required>
    <br><br>

    <label>Semester:</label><br>
    <input type="number" name="semester"
           min="1" max="14" required>
    <br><br>

    <label>Email:</label><br>
    <input type="email" name="email" required>
    <br><br>

    <button type="submit">Kirim Data</button>

</form>

<?php

// Menampilkan pesan kesalahan
if ($error) {

    echo "<h3>Terjadi Kesalahan:</h3>";

    foreach ($error as $pesan) {
        echo "<p>" . htmlspecialchars($pesan) . "</p>";
    }
}

// Menampilkan data jika valid
if ($data !== null) {

    echo "<h3>Data Mahasiswa Berhasil Diterima</h3>";

    foreach ($data as $label => $nilai) {

        echo htmlspecialchars(ucfirst($label)) . ": " .
             htmlspecialchars((string)$nilai) . "<br>";
    }
}

?>
