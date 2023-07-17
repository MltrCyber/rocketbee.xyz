<?= $this->extend('layouts/master_karyawan') ?>
<?= $this->section('content') ?>
<!-- partial:index.partial.html -->
<div class="screen-1">
    <center>
    <span id="remainingTime" style="display:none;"></span>
        <h2>Scan QR Code</h2>
        <div class="form-group">
            <div id="reader"></div>
        </div>
        <input type="hidden" class="form-control" id="qrcode">
        <button class="login btn-block mt-2" id="pintu" onclick="absen()" disabled>Silahkan Scan QR Code</button>
    </center>
</div>


<!-- partial -->
<script src="<?= base_url() ?>/login_app/dist/html5-qrcode.min.js"></script>
<script>
    var isMobile = false; //initiate as false
    // device detection
    if (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent) ||
        /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0, 4))) {
        isMobile = true;
        $('.screen-1').css('zoom', '180%');
        $('.screen-1').css('width', '85%');
    }
</script>
<script type="text/javascript">
    function onScanSuccess(qrCodeMessage) {
        $('#qrcode').val(qrCodeMessage);
        $('#pintu').removeAttr('disabled');
        $('#pintu').text('Absensi Sekarang!');
        $('.login').css('background-color', '#04a08b')
        $('.login').css('color', 'white')
    }

    function absen() {
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>/absensimasuk/hadir",
            data: {
                qr: $('#qrcode').val()
            },
            dataType: "JSON",
            success: function(response) {
                $('#qrcode').val("");
                if (response.sukses) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.sukses.absensi,
                        showConfirmButton: false,
                        timer: 1400
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: response.error.absensi,
                        showConfirmButton: false,
                        timer: 1400
                    });
                }
                setTimeout(function() {
                    window.location.href = "<?= base_url() ?>/home/menu"
                }, 1400)

            },
        }).fail(function(xhr, err) {
            var responseTitle = $(xhr.responseText).filter('title').get(0);
            alert($(responseTitle).text() + "\n" + formatErrorMessage(xhr, err));
        })
    };

    function onScanError(errorMessage) {
        //handle scan error
    }
    var html5QrcodeScanner = new Html5QrcodeScanner(
        "reader", {
            fps: 30,
            qrbox: 250
        });
    html5QrcodeScanner.render(onScanSuccess, onScanError);
</script>

<script type="module">
    // Import the functions you need from the SDKs you need
    import {
        initializeApp
    } from "https://www.gstatic.com/firebasejs/9.23.0/firebase-app.js";
    import {
        getAnalytics
    } from "https://www.gstatic.com/firebasejs/9.23.0/firebase-analytics.js";
    import {
        getDatabase,
        ref,
        set,
        onValue
    } from "https://www.gstatic.com/firebasejs/9.23.0/firebase-database.js";

    // Konfigurasi Firebase Aplikasi Web Anda
    const firebaseConfig = {
        apiKey: "AIzaSyAfDVgOyCQHMYeNVearY85yYPLK207aC9M",
        authDomain: "tugasakhir-d4955.firebaseapp.com",
        databaseURL: "https://tugasakhir-d4955-default-rtdb.firebaseio.com",
        projectId: "tugasakhir-d4955",
        storageBucket: "tugasakhir-d4955.appspot.com",
        messagingSenderId: "255153377851",
        appId: "1:255153377851:web:810a45db5fe3e5890c421e",
        measurementId: "G-5H6DMYJPMR"
    };
    // Menginisialisasi firebase
    const app = initializeApp(firebaseConfig);
    const analytics = getAnalytics(app);

    // Dapatkan referensi ke database Firebase Realtime
    const database = getDatabase();

    // Dapatkan data dari lokasi tertentu di database
    const dataRef = ref(database, "/doorlock");
    const dataTimeleft = ref(database, "/timeleft");
    const dataDistance = ref(database, "/distance");

    onValue(dataTimeleft, (snapshot) => {
        const data = snapshot.val();
        const remainingTimeElement = document.getElementById("remainingTime");
        remainingTimeElement.textContent = data;
    });

    onValue(dataDistance, (snapshot) => {
        const data = snapshot.val();
        const pintuElement = document.getElementById("pintu");
        if (data === 0) {
            pintuElement.disabled = true;
        }
    });

    let newData = 0;

    onValue(dataRef, (snapshot) => {
        const data = snapshot.val();
        const pintuElement = document.getElementById('pintu');

        if (data === 1) {
            newData = 0;
            pintuElement.textContent = 'Tutup Pintu';
            pintuElement.style.color = '#f4b30d';
            pintuElement.style.backgroundColor = 'black';
        } else {
            newData = 1;
            pintuElement.textContent = 'Buka Pintu';
            pintuElement.style.color = 'black';
            pintuElement.style.backgroundColor = '#f4b30d';
        }
    });

    // Fungsi untuk menangani acara OnClick
    const handleClick = () => {
        set(dataRef, newData)
            .then(() => {
                console.log("Data set successfully.");
                const remainingTime = parseInt(document.getElementById("remainingTime").textContent);

                Swal.fire({
                    title: 'Status Pintu',
                    html: 'Status pintu akan berubah dalam <b></b> milidetik.',
                    timer: remainingTime,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading();
                        const b = Swal.getHtmlContainer().querySelector('b');
                        let timerInterval;
                        timerInterval = setInterval(() => {
                            const remaining = Swal.getTimerLeft();
                            b.textContent = remaining.toFixed(0);

                            if (remaining <= 0) {
                                clearInterval(timerInterval);
                            }
                            location.reload()

                        }, 100);
                    },
                    willClose: () => {
                        clearInterval(timerInterval);
                    }
                }).then((result) => {
                    /* Read more about handling dismissals below */
                    if (result.dismiss === Swal.DismissReason.timer) {
                        console.log('I was closed by the timer');
                    }
                });
            })
            .catch((error) => {
                console.error("Error setting data:", error);
            });


    };

    // Add onclick event to #pintu element
    const pintuElement = document.getElementById('pintu');
    pintuElement.addEventListener('click', handleClick);
</script>
<?= $this->endSection() ?>