<x-alumni.child-layout>
    <!-- OTP Verification Section -->
    <div class="rounded-3xl p-6 shadow-xl content-animation">
        <h1 class="text-2xl font-bold text-primary text-center mb-2">Verifikasi OTP</h1>
        <p class="text-gray-800 text-center">Mau mastiin kalau ini kamu bukan yang lain 😆</p>
        <p class="text-gray-800 text-center mb-6">OTP udah dikirim ke nomormu: {{ $whatsapp }}</p>

        {{-- <p class="text-gray-800">Nomormu: {{ $whatsapp }}</p> --}}
        
        <form action="{{route('setup.otp.verify')}}" method="POST" id="otp-form">
            @csrf
            <input type="hidden" name="token" value="{{$token}}">
            <!-- OTP Input Fields -->
            {{-- <div class="flex justify-center space-x-2 mb-6">
                <input type="text" maxlength="1" name="otp" class="otp-input" autofocus oninput="handleInput(event)" onkeydown="handleBackspace(event)" data-index="0">
                <input type="text" maxlength="1" name="otp" class="otp-input" oninput="handleInput(event)" onkeydown="handleBackspace(event)" data-index="1">
                <input type="text" maxlength="1" name="otp" class="otp-input" oninput="handleInput(event)" onkeydown="handleBackspace(event)" data-index="2">
                <input type="text" maxlength="1" name="otp" class="otp-input" oninput="handleInput(event)" onkeydown="handleBackspace(event)" data-index="3">
                <input type="text" maxlength="1" name="otp" class="otp-input" oninput="handleInput(event)" onkeydown="handleBackspace(event)" data-index="4">
                <input type="text" maxlength="1" name="otp" class="otp-input" oninput="handleInput(event)" onkeydown="handleBackspace(event)" data-index="5">
            </div> --}}

            <div class="flex items-center justify-center gap-3 px-6">
                <input
                    type="text"
                    class="w-12 h-12 text-center text-2xl font-extrabold text-slate-900 bg-slate-100 border border-transparent hover:border-slate-200 appearance-none rounded p-2 outline-none focus:bg-white focus:border-primary focus:ring-2 focus:ring-primary"
                    pattern="\d*" maxlength="1" name="otp1" />
                <input
                    type="text"
                    class="w-12 h-12 text-center text-2xl font-extrabold text-slate-900 bg-slate-100 border border-transparent hover:border-slate-200 appearance-none rounded p-2 outline-none focus:bg-white focus:border-primary focus:ring-2 focus:ring-primary"
                    maxlength="1" name="otp2" />
                <input
                    type="text"
                    class="w-12 h-12 text-center text-2xl font-extrabold text-slate-900 bg-slate-100 border border-transparent hover:border-slate-200 appearance-none rounded p-2 outline-none focus:bg-white focus:border-primary focus:ring-2 focus:ring-primary"
                    maxlength="1" name="otp3" />
                <input
                    type="text"
                    class="w-12 h-12 text-center text-2xl font-extrabold text-slate-900 bg-slate-100 border border-transparent hover:border-slate-200 appearance-none rounded p-2 outline-none focus:bg-white focus:border-primary focus:ring-2 focus:ring-primary"
                    maxlength="1" name="otp4" />
                <input
                    type="text"
                    class="w-12 h-12 text-center text-2xl font-extrabold text-slate-900 bg-slate-100 border border-transparent hover:border-slate-200 appearance-none rounded p-2 outline-none focus:bg-white focus:border-primary focus:ring-2 focus:ring-primary"
                    maxlength="1" name="otp5" />
                <input
                    type="text"
                    class="w-12 h-12 text-center text-2xl font-extrabold text-slate-900 bg-slate-100 border border-transparent hover:border-slate-200 appearance-none rounded p-2 outline-none focus:bg-white focus:border-primary focus:ring-2 focus:ring-primary"
                    maxlength="1" name="otp6" />
            </div>
    
            
            <!-- OTP Input Fields -->
            {{-- <div class="flex justify-center space-x-2 mb-2">
                <input type="text" class="w-full font-medium rounded-xl py-2 px-4 mt-2 focus:outline-none focus:ring-2 focus:ring-primary" placeholder="XXXXXX" x-mask="999999" name="otp" required autofocus>
            </div> --}}

            
            <!-- Submit Button -->
            <div class="text-center my-6">
                <button class="w-full px-4 py-2 bg-primary text-white rounded-xl hover:bg-primary/90 transition-all" type="submit">
                    Verifikasi OTP
                </button>
            </div>
        </form>
        {{-- <form  id="resendOtpForm" action="{{ route('resendOtp')}}" method="post">
            @csrf
            <input type="hidden" name="token" value="{{$token}}">
            <!-- Resend OTP Button -->
            <div class="text-center mb-4">
                <button class="text-primary hover:underline" id="resendOtpBtn" type="submit" disabled>Resend OTP <span id="countdownTimer"></span></button>
            </div>
        </form> --}}
        <div class="mb-4 text-left">
            <form action="{{ route('setup.otp.change')}}" method="post">
                @csrf
                <input type="hidden" name="token" value="{{$token}}">
                <p>Nomor salah? <button type="submit" class="text-primary font-bold">Perbaiki</button></p>
            </form>
            <form id="resendOtpForm" action="{{ route('setup.otp.resend')}}" method="post">
                @csrf
                <input type="hidden" name="token" value="{{$token}}">
                <p>Belum menerima kode? <button type="submit" class="text-primary font-bold">Kirim Ulang</button></p>
            </form>
        </div>
        {{-- <div class="flex flex-col justify-center items-center">
            <div class="w-full max-w-md">
                <form id="resendOtpForm" action="{{ route('resendOtp') }}" method="POST">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    
                    <div class="text-center">
                        <p class="mb-4 text-gray-600">Belum menerima kode?</p>
                        <button 
                            id="resendOtpBtn" 
                            type="submit" 
                            class="w-full px-4 py-2 border-2 rounded-xl hover:bg-primary disabled:bg-gray-300 disabled:text-white disabled:cursor-not-allowed transition-all"
                            
                        >
                            Kirim Ulang <span id="countdownTimer" class="ml-2"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div> --}}


        {{-- <script>
            document.addEventListener('DOMContentLoaded', function() {
                const resendOtpBtn = document.getElementById('resendOtpBtn');
                const countdownTimer = document.getElementById('countdownTimer');
                const resendOtpForm = document.getElementById('resendOtpForm');

                // Fungsi untuk format waktu
                function formatTime(seconds) {
                    const mins = Math.floor(seconds / 60);
                    const secs = seconds % 60;
                    return `(${mins}:${secs < 10 ? '0' : ''}${secs})`;
                }

                // Fungsi untuk mendapatkan sisa waktu dari cache
                function getRemainingTimeFromCache() {
                    const lastResendTime = localStorage.getItem('lastResendTime');
                    const resendAttempts = parseInt(localStorage.getItem('resendAttempts') || '0');
                    
                    if (lastResendTime) {
                        const delayMinutes = resendAttempts === 0 ? 1 : 2;
                        const totalSeconds = delayMinutes * 60;
                        const elapsedSeconds = Math.floor((new Date() - new Date(lastResendTime)) / 1000);
                        const remainingSeconds = Math.max(totalSeconds - elapsedSeconds, 0);
                        
                        return {
                            remainingSeconds,
                            resendAttempts
                        };
                    }
                    
                    return {
                        remainingSeconds: resendAttempts === 0 ? 60 : 120,
                        resendAttempts
                    };
                }

                // Fungsi utama hitung mundur
                function startCountdown(initialSeconds) {
                    let remainingSeconds = initialSeconds;
                    
                    // Pastikan hanya satu interval yang berjalan
                    if (window.countdownInterval) {
                        clearInterval(window.countdownInterval);
                    }
                    
                    // Nonaktifkan tombol
                    resendOtpBtn.disabled = true;
                    
                    // Tampilan awal
                    countdownTimer.textContent = formatTime(remainingSeconds);
                    
                    window.countdownInterval = setInterval(() => {
                        remainingSeconds--;
                        
                        // Update tampilan
                        countdownTimer.textContent = formatTime(remainingSeconds);
                        
                        // Cek apakah hitung mundur selesai
                        if (remainingSeconds <= 0) {
                            clearInterval(window.countdownInterval);
                            resendOtpBtn.disabled = false;
                            countdownTimer.textContent = '';
                        }
                    }, 1000);
                }

                // Fungsi untuk memulai ulang hitung mundur
                function restartCountdown() {
                    const resendAttempts = parseInt(localStorage.getItem('resendAttempts') || '0');
                    const newAttempts = resendAttempts + 1;
                    
                    // Simpan waktu terakhir resend dan jumlah percobaan
                    localStorage.setItem('lastResendTime', new Date().toISOString());
                    localStorage.setItem('resendAttempts', newAttempts.toString());
                    
                    // Hitung mundur sesuai jumlah percobaan
                    const countdownSeconds = newAttempts === 1 ? 60 : 120;
                    startCountdown(countdownSeconds);
                }

                // Periksa sisa waktu saat halaman dimuat
                function initializeCountdown() {
                    const { remainingSeconds, resendAttempts } = getRemainingTimeFromCache();
                    
                    if (remainingSeconds > 0) {
                        startCountdown(remainingSeconds);
                    } else {
                        // Reset percobaan jika waktu sudah habis
                        localStorage.removeItem('lastResendTime');
                        localStorage.removeItem('resendAttempts');
                        startCountdown(resendAttempts === 0 ? 60 : 120);
                    }
                }

                // Inisialisasi hitung mundur
                initializeCountdown();

                // Event listener untuk submit form
                resendOtpForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    // Kirim OTP melalui AJAX
                    fetch(this.action, {
                        method: 'POST',
                        body: new FormData(this),
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // OTP berhasil dikirim ulang
                            restartCountdown();
                            console.log('OTP Resent Successfully');
                        } else {
                            // Tangani kegagalan
                            console.error('OTP Resend Failed');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                });
            });
        </script> --}}
    {{-- <script>
        console.log('Script berjalan');
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Script berjalan');
            const resendOtpBtn = document.getElementById('resendOtpBtn');
            const countdownTimer = document.getElementById('countdownTimer');
            const resendOtpForm = document.getElementById('resendOtpForm');
        
            // Ambil data dari session/local storage atau set default
            let resendAttempts = localStorage.getItem('resendAttempts') || 0;
            let lastResendTime = localStorage.getItem('lastResendTime');
        
            // Tentukan delay berdasarkan percobaan
            const getDelay = () => resendAttempts == 0 ? 1 : 2;
        
            function startCountdown(minutes) {
                let seconds = minutes * 60;
                
                const countdownInterval = setInterval(() => {
                    const minutesLeft = Math.floor(seconds / 60);
                    const secondsLeft = seconds % 60;
        
                    countdownTimer.textContent = `(${minutesLeft}:${secondsLeft < 10 ? '0' : ''}${secondsLeft})`;
                    
                    if (seconds <= 0) {
                        clearInterval(countdownInterval);
                        resendOtpBtn.disabled = false;
                        countdownTimer.textContent = '';
                    }
                    
                    seconds--;
                }, 1000);
            }
        
            // Cek apakah masih dalam masa tunggu
            function checkResendEligibility() {
                if (!lastResendTime) return;
        
                const timeDiff = (new Date() - new Date(lastResendTime)) / 60000;
                const delay = getDelay();
        
                if (timeDiff < delay) {
                    resendOtpBtn.disabled = true;
                    startCountdown(delay - timeDiff);
                }
            }
        
            // Inisialisasi
            checkResendEligibility();
        
            // Event listener untuk form
            resendOtpForm.addEventListener('submit', function(e) {
                // Update local storage untuk tracking
                resendAttempts++;
                localStorage.setItem('resendAttempts', resendAttempts);
                localStorage.setItem('lastResendTime', new Date().toISOString());
        
                // Nonaktifkan tombol segera setelah submit
                resendOtpBtn.disabled = true;
                
                // Hitung mundur sesuai aturan
                startCountdown(getDelay());
            });
        });
    </script> --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('otp-form')
            const inputs = [...form.querySelectorAll('input[type=text]')]
            const submit = form.querySelector('button[type=submit]')
    
            const handleKeyDown = (e) => {
                if (
                    !/^[0-9]{1}$/.test(e.key)
                    && e.key !== 'Backspace'
                    && e.key !== 'Delete'
                    && e.key !== 'Tab'
                    && !e.metaKey
                ) {
                    e.preventDefault()
                }
    
                if (e.key === 'Delete' || e.key === 'Backspace') {
                    const index = inputs.indexOf(e.target);
                    if (index > 0) {
                        inputs[index - 1].value = '';
                        inputs[index - 1].focus();
                    }
                }
            }
    
            const handleInput = (e) => {
                const { target } = e
                const index = inputs.indexOf(target)
                if (target.value) {
                    if (index < inputs.length - 1) {
                        inputs[index + 1].focus()
                    } else {
                        submit.focus()
                    }
                }
            }
    
            const handleFocus = (e) => {
                e.target.select()
            }
    
            const handlePaste = (e) => {
                e.preventDefault()
                const text = e.clipboardData.getData('text')
                if (!new RegExp(`^[0-9]{${inputs.length}}$`).test(text)) {
                    return
                }
                const digits = text.split('')
                inputs.forEach((input, index) => input.value = digits[index])
                submit.focus()
            }
    
            inputs.forEach((input) => {
                input.addEventListener('input', handleInput)
                input.addEventListener('keydown', handleKeyDown)
                input.addEventListener('focus', handleFocus)
                input.addEventListener('paste', handlePaste)
            })
        })                        
    </script>
</x-alumni.child-layout>

@push('script')
@endpush