<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Papan Antrian</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #fdfbfb 0%, #ebedee 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .main-card {
            background: white;
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.08);
            padding: 60px 40px;
            text-align: center;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .next-card {
            background: white;
            border-radius: 24px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            padding: 30px;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .title {
            font-size: 2.5rem;
            color: #6c757d;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: 600;
        }
        .number {
            font-size: 16rem;
            font-weight: 900;
            color: #0d6efd;
            line-height: 1;
            margin: 20px 0;
            text-shadow: 4px 4px 10px rgba(13, 110, 253, 0.15);
        }
        .name {
            font-size: 4rem;
            color: #212529;
            font-weight: 700;
        }
        .empty-state {
            font-size: 3.5rem;
            color: #adb5bd;
            font-weight: bold;
        }
        
        .next-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #495057;
            margin-bottom: 25px;
            border-bottom: 3px solid #e9ecef;
            padding-bottom: 15px;
        }
        .next-list {
            flex-grow: 1;
            overflow-y: auto;
            padding-right: 10px;
        }
        /* Custom Scrollbar for next list */
        .next-list::-webkit-scrollbar {
            width: 8px;
        }
        .next-list::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }
        .next-list::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 4px;
        }
        
        .next-item {
            background: #f8f9fa;
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            border-left: 6px solid #6c757d;
            transition: transform 0.2s;
        }
        .next-item:hover {
            transform: translateX(5px);
            border-left-color: #0d6efd;
        }
        .next-item .next-number {
            font-size: 2.5rem;
            font-weight: 800;
            color: #495057;
            width: 80px;
            text-align: center;
        }
        .next-item .next-name {
            font-size: 1.5rem;
            font-weight: 600;
            color: #212529;
            margin-left: 15px;
            word-break: break-word;
        }
    </style>
</head>
<body>
    <audio src="{{ asset('dingdong.mp3') }}" id="audio-dingdong" hidden></audio>

    <div class="container-fluid px-5 py-4">
        <div class="row g-4" style="height: 90vh;">
            <!-- Kolom Utama -->
            <div class="col-md-8 h-100">
                <div class="main-card" id="displayArea">
                    <div class="empty-state">Menunggu Antrian...</div>
                </div>
            </div>
            
            <!-- Kolom Selanjutnya -->
            <div class="col-md-4 h-100">
                <div class="next-card">
                    <div class="next-title">Bersiap-siap (Selanjutnya)</div>
                    <div class="next-list" id="nextArea">
                        <div class="text-muted fs-4 mt-3">Belum ada antrian selanjutnya.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const displayArea = document.getElementById('displayArea');
        const nextArea = document.getElementById('nextArea');
        let lastDipanggilId = null;

        // Fallback: silent unlock audio jika user tanpa sengaja mengklik layar
        document.body.addEventListener('click', function() {
            const audio = document.getElementById('audio-dingdong');
            if(audio) {
                audio.volume = 0;
                audio.play().then(() => {
                    audio.pause();
                    audio.currentTime = 0;
                    audio.volume = 1;
                }).catch(e=>{});
            }
            window.speechSynthesis.speak(new SpeechSynthesisUtterance(''));
        }, {once: true});

        // Load daftar suara dari OS/Browser
        window.speechSynthesis.onvoiceschanged = function() { 
            window.speechSynthesis.getVoices(); 
        };

        function loadAntrianPapan() {
            fetch('{{ route("antrian.data_papan") }}')
                .then(response => response.json())
                .then(data => {
                    const lastCalled = data.dipanggil;
                    const nextList = data.selanjutnya;
                    
                    // Render Daftar Bersiap-siap
                    if (nextList && nextList.length > 0) {
                        let htmlNext = '';
                        nextList.forEach(item => {
                            htmlNext += `
                                <div class="next-item">
                                    <div class="next-number">${item.nomor_antrian}</div>
                                    <div class="next-name">${item.nama}</div>
                                </div>
                            `;
                        });
                        nextArea.innerHTML = htmlNext;
                    } else {
                        nextArea.innerHTML = '<div class="text-muted fs-4 mt-3">Belum ada antrian selanjutnya.</div>';
                    }

                    // Render Antrian Saat Ini
                    if (lastCalled) {
                        displayArea.innerHTML = `
                            <div class="title">Nomor Antrian Saat Ini</div>
                            <div class="number">${lastCalled.nomor_antrian}</div>
                            <div class="name">${lastCalled.nama}</div>
                        `;

                        if (lastCalled.id !== lastDipanggilId) {
                            lastDipanggilId = lastCalled.id;
                            
                            try {
                                // Batalkan speech yang sedang berjalan
                                window.speechSynthesis.cancel();

                                // Buat pesan dinamis
                                const pesan = new SpeechSynthesisUtterance(`Nomor antrian ${lastCalled.nomor_antrian}. ${lastCalled.nama}, silakan masuk.`);
                                pesan.lang = 'id-ID';
                                pesan.rate = 0.85;
                                pesan.pitch = 1.0;
                                pesan.volume = 1.0;

                                // Paksa gunakan suara Indonesia
                                let voices = window.speechSynthesis.getVoices();
                                let idVoice = voices.find(v => {
                                    let l = v.lang.toLowerCase();
                                    let n = v.name.toLowerCase();
                                    return l === 'id-id' || l === 'id_id' || l === 'id' || n.includes('indonesia');
                                });
                                
                                if (idVoice) {
                                    pesan.voice = idVoice;
                                } else {
                                    console.warn('Suara Indonesia tidak terdeteksi di browser ini. Menggunakan suara default.');
                                }

                                const audio = document.getElementById('audio-dingdong');
                                if (audio) {
                                    audio.currentTime = 0;
                                    
                                    // Mainkan dingdong terlebih dahulu
                                    audio.play().catch(e => {
                                        console.warn('Autoplay Audio diblokir browser:', e);
                                        // Fallback: Jika pemutaran audio ditolak, langsung panggil TTS
                                        window.speechSynthesis.speak(pesan);
                                    });

                                    // Setelah dingdong selesai, jalankan TTS
                                    audio.onended = function() {
                                        window.speechSynthesis.speak(pesan);
                                    };
                                } else {
                                    window.speechSynthesis.speak(pesan);
                                }
                            } catch (e) {
                                console.warn('Error auto-play audio & TTS:', e);
                            }
                        }
                    } else {
                        displayArea.innerHTML = '<div class="empty-state">Menunggu Antrian...</div>';
                    }
                })
                .catch(err => console.error('Error fetching data:', err));
        }

        loadAntrianPapan();
        setInterval(loadAntrianPapan, 1500);
    </script>
</body>
</html>
