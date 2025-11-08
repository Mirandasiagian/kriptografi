LAPORAN ANALISIS KRIPTOGRAFI PADA PROYEK WEB PHP
1. Pendahuluan

Kriptografi merupakan cabang ilmu yang mempelajari teknik-teknik penyandian pesan agar tidak dapat dibaca oleh pihak yang tidak berwenang. Dalam dunia teknologi informasi, kriptografi berperan penting untuk menjaga kerahasiaan, integritas, dan autentikasi data.
Proyek kriptografi yang dianalisis dalam laporan ini adalah sebuah aplikasi web berbasis PHP, yang di dalamnya terdapat file Cipher.php dan beberapa komponen pendukung lain seperti Profiler.php serta halaman tampilan web. Aplikasi ini digunakan untuk melakukan proses enkripsi dan dekripsi teks, yang berguna untuk melindungi data pengguna dari penyalahgunaan pihak luar.

2. Tujuan

Adapun tujuan dari analisis ini adalah:

Mengetahui bagaimana cara kerja sistem kriptografi pada aplikasi tersebut.

Menjelaskan proses enkripsi dan dekripsi yang dilakukan pada file Cipher.php.

Menentukan metode kriptografi yang digunakan (misalnya substitusi, Caesar cipher, atau metode modern lainnya).

Menilai tingkat keamanan dari implementasi kriptografi tersebut.

3. Landasan Teori
a. Pengertian Kriptografi

Kriptografi berasal dari bahasa Yunani “kryptos” yang berarti tersembunyi, dan “graphien” yang berarti tulisan. Secara umum, kriptografi adalah teknik untuk mengamankan pesan dengan cara mengubah bentuk data asli (plaintext) menjadi bentuk data acak yang tidak bermakna (ciphertext) menggunakan algoritma enkripsi.

b. Komponen Utama Kriptografi

Plaintext – data asli atau pesan sebelum disandikan.

Ciphertext – hasil enkripsi yang tidak dapat dibaca tanpa proses dekripsi.

Key (Kunci) – parameter rahasia yang digunakan untuk mengontrol proses enkripsi dan dekripsi.

Algoritma Enkripsi/Dekripsi – langkah-langkah matematis untuk mengubah plaintext menjadi ciphertext dan sebaliknya.

c. Jenis Kriptografi

Kriptografi Simetris → menggunakan satu kunci yang sama untuk enkripsi dan dekripsi.

Kriptografi Asimetris → menggunakan pasangan kunci publik dan privat.

Kriptografi Hash → menghasilkan nilai unik (hash) untuk keperluan verifikasi integritas data.

4. Analisis Sistem Kriptografi pada Proyek

Berdasarkan hasil analisis terhadap struktur proyek, file Cipher.php merupakan komponen utama yang menangani proses enkripsi dan dekripsi teks. Prosesnya melibatkan operasi logika sederhana seperti penggeseran karakter (Caesar Cipher) atau perubahan nilai ASCII untuk menyandikan pesan.

a. Alur Proses

Pengguna memasukkan teks ke dalam form web (misalnya kalimat atau kata sandi).

Sistem akan mengambil input tersebut sebagai plaintext.

File Cipher.php melakukan proses enkripsi, misalnya dengan menggeser setiap huruf sejumlah nilai tertentu (contoh: geser +4).

Contoh:
Plaintext: HELLO
Enkripsi (geser +4): LIPPS

Hasil enkripsi ditampilkan atau disimpan dalam database sebagai ciphertext.

Jika pengguna ingin membaca kembali pesan, sistem menjalankan proses dekripsi dengan cara menggeser karakter ke arah berlawanan (−4).

Ciphertext: LIPPS
Dekripsi (geser −4): HELLO
b. Potongan Logika Umum (contoh representatif)
function encrypt($text, $shift) {
    $result = '';
    for ($i = 0; $i < strlen($text); $i++) {
        $char = ord($text[$i]);           // konversi karakter ke ASCII
        $char = ($char + $shift) % 256;   // geser nilai ASCII
        $result .= chr($char);            // ubah kembali ke karakter
    }
    return base64_encode($result);        // hasil akhir disandikan ke Base64
}

function decrypt($text, $shift) {
    $text = base64_decode($text);
    $result = '';
    for ($i = 0; $i < strlen($text); $i++) {
        $char = ord($text[$i]);
        $char = ($char - $shift + 256) % 256;
        $result .= chr($char);
    }
    return $result;
}


Kode di atas menunjukkan bahwa sistem menggunakan algoritma substitusi sederhana dengan pergeseran karakter (Caesar Cipher) ditambah encoding Base64 agar hasilnya aman ditransmisikan melalui web.

5. Tools yang Digunakan

Berikut adalah beberapa perangkat dan bahasa yang digunakan dalam proyek kriptografi ini:

No	Tools / Software	Fungsi Utama
1	PHP	Bahasa utama untuk logika kriptografi (enkripsi/dekripsi).
2	HTML / CSS / JavaScript	Untuk tampilan antarmuka web.
3	XAMPP / Apache Server	Menjalankan aplikasi web secara lokal.
4	phpMyAdmin / MySQL	Menyimpan data hasil enkripsi (jika menggunakan database).
5	Text Editor (VS Code / Sublime)	Untuk menulis dan mengedit kode sumber.
6. Keunggulan dan Kelemahan Sistem
Keunggulan:

Mudah diimplementasikan dengan logika sederhana.

Proses enkripsi dan dekripsi cepat karena tidak menggunakan operasi matematis kompleks.

Cocok untuk pembelajaran dasar kriptografi.

Kelemahan:

Tidak aman untuk penggunaan profesional karena mudah ditebak melalui analisis frekuensi.

Tidak memiliki manajemen kunci yang kuat.

Tidak mendukung panjang teks besar dengan keamanan tinggi.
