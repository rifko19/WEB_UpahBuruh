// Mengatur Waktu Realtime
function getCurrentTime() {
    const now = new Date();
    const hours = now.getHours().toString().padStart(2, '0');
    const minutes = now.getMinutes().toString().padStart(2, '0');
    return `${hours}:${minutes}`;
}

document.addEventListener('DOMContentLoaded', function () {
    const jamMulaiInput = document.getElementById('Jam_Mulai');
    jamMulaiInput.value = "07:00";
    const jamSelesaiInput = document.getElementById('Jam_Selesai');
    jamSelesaiInput.value = getCurrentTime();
});

document.getElementById("tampilkan").addEventListener("click", function() {
    document.getElementById("data-gaji-perbulan").style.display = "block";
});
document.getElementById("tampilkan").addEventListener("click", function() {
    document.getElementById("data-gaji").style.display = "none";
});

document.getElementById("kembali").addEventListener("click", function() {
    document.getElementById("data-gaji-perbulan").style.display = "none";
});
document.getElementById("kembali").addEventListener("click", function() {
    document.getElementById("data-gaji").style.display = "block";
});
// method hapus
// document.addEventListener('DOMContentLoaded', function () {
//     const tombolHapus = document.querySelectorAll('.tb-hapus');

//     tombolHapus.forEach(function (button) {
//         button.addEventListener('click', async function (event) {
//             event.preventDefault();

//             const idBuruh = this.getAttribute('data-id');

//             if (idBuruh) {
//                 const konfirmasi = confirm('Apakah Anda yakin ingin menghapus data ini?');

//                 if (konfirmasi) {
//                     try {
//                         const response = await fetch('hapus_buruh.php', {
//                             method: 'POST',
//                             headers: {
//                                 'Content-Type': 'application/json',
//                             },
//                             body: JSON.stringify({ id_buruh: idBuruh }),
//                         });

//                         const data = await response.json();

//                         if (data.success) {
//                             alert(data.message);
//                             window.location.reload();
//                         } else {
//                             alert(data.message);
//                         }
//                     } catch (error) {
//                         console.error('Error:', error);
//                         alert('Terjadi kesalahan saat menghapus data.');
//                     }
//                 }
//             } else {
//                 console.error('ID Buruh tidak valid.');
//             }
//         });
//     });
// });

