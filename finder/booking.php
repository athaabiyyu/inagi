<?php
/**
 * Template Name: Booking Page
 */

get_header();

// Ambil data listing
$listing_id = isset($_GET['listing_id']) ? absint($_GET['listing_id']) : 0;

if (!class_exists('HivePress\Models\Listing')) {
    wp_die('Plugin HivePress tidak aktif!');
}

$listing = HivePress\Models\Listing::query()->get_by_id($listing_id);

if (!$listing || !$listing->get_status() === 'publish') {
    wp_die('Listing tidak ditemukan atau belum dipublikasikan!');
}
?>

<style>
    .checkout-container {
        max-width: 700px;
        margin: 0 auto;
        padding: 20px;
        font-family: 'Arial', sans-serif;
    }
    
    .section-title {
        font-size: 1.2em;
        margin: 20px 0 10px;
        padding-bottom: 5px;
        border-bottom: 2px solid #333;
    }
    
    .form-group {
        margin-bottom: 15px;
    }
    
    input, select {
        width: 100%;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-sizing: border-box;
    }
    
    .btn-whatsapp {
        background: #25D366;
        color: white;
        padding: 12px 24px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        width: 100%;
        font-size: 1.1em;
        transition: background 0.3s;
        margin-top: 20px;
    }
    
    .btn-whatsapp:hover {
        background: #128C7E;
    }

    @media (max-width: 768px) {
        .checkout-container {
            padding: 15px;
        }
        
        input, select {
            padding: 10px;
            font-size: 16px;
        }
        
        .btn-whatsapp {
            padding: 15px 24px;
            font-size: 1em;
        }
    }
</style>

<div class="checkout-container">
    <h1>CHECKOUT</h1>
    <p class="text-muted">Selesaikan Pemesanan<br>Lengkapi data di bawah untuk melanjutkan</p>

    <!-- Ringkasan Pemesanan -->
    <div class="section-title">Ringkasan Pemesanan</div>
    <div class="form-group">
        <label>Nama Layanan</label>
        <input type="text" value="<?php echo esc_attr($listing_title); ?>" readonly>
    </div>
    
    <div class="form-group">
        <label>Harga Satuan</label>
        <input type="text" value="Rp <?php echo number_format($listing_price, 0, ',', '.'); ?>" readonly>
    </div>
    
    <div class="form-group">
        <label>Total Pembayaran</label>
        <input type="text" value="Rp <?php echo number_format($total_payment, 0, ',', '.'); ?>" readonly>
    </div>

    <!-- Data Customer -->
    <div class="section-title">Data Customer</div>
    <form id="bookingForm" onsubmit="event.preventDefault(); sendToWhatsApp()">
        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" id="customer_name" required>
        </div>
        
        <div class="form-group">
            <label>Nomor WhatsApp</label>
            <input type="tel" id="customer_phone" pattern="08[0-9]{9,12}" required>
            <small class="text-muted">Contoh: 081234567890</small>
        </div>
        
        <div class="form-group">
            <label>Alamat Lengkap</label>
            <input type="text" id="address" placeholder="Ketik untuk mencari alamat..." required>
        </div>

        <!-- Waktu Pengerjaan -->
        <div class="section-title">Jadwal Pengerjaan</div>
        <div class="form-group">
            <label>Metode Pelaksanaan</label>
            <select id="workflow" required>
                <option value="">Pilih Metode</option>
                <option value="survei">Survei Lokasi Terlebih Dahulu</option>
                <option value="langsung">Langsung Dikerjakan</option>
            </select>
        </div>
        
        <div class="row g-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Tanggal Pengerjaan</label>
                    <input type="date" id="work_date" min="<?php echo date('Y-m-d'); ?>" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Waktu Pengerjaan</label>
                    <input type="time" id="work_time" min="08:00" max="18:00" required>
                </div>
            </div>
        </div>

        <button type="submit" class="btn-whatsapp">
            <i class="fab fa-whatsapp"></i> Kirim Pesanan via WhatsApp
        </button>
    </form>
</div>

<!-- Google Maps API -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA-YVE0U9M-giKLXwQryz-lc9VAlv1g_Us&libraries=places&callback=initAutocomplete"></script>

<script>
    // Autocomplete Alamat
    function initAutocomplete() {
        new google.maps.places.Autocomplete(
            document.getElementById('address'),
            { types: ['geocode'] }
        );
    }

    // Fungsi Kirim ke WhatsApp
    function sendToWhatsApp() {
        // Ambil nilai form
        const formData = {
            name: document.getElementById('customer_name').value.trim(),
            phone: document.getElementById('customer_phone').value.trim(),
            address: document.getElementById('address').value.trim(),
            workflow: document.getElementById('workflow').value,
            date: document.getElementById('work_date').value,
            time: document.getElementById('work_time').value
        };

        // Validasi form
        if (!Object.values(formData).every(Boolean)) {
            alert('Harap lengkapi semua kolom yang wajib diisi!');
            return;
        }

        // Format pesan
        const message = `📋 *PESANAN BARU* 📋\n\n
            🏷️ *Layanan:* ${encodeURIComponent('<?php echo $listing_title; ?>')}\n
            💵 *Harga:* Rp ${encodeURIComponent('<?php echo number_format($listing_price, 0, ',', '.'); ?>')}\n
            💰 *Total:* Rp ${encodeURIComponent('<?php echo number_format($total_payment, 0, ',', '.'); ?>')}\n
            🔗 *Link Listing:* ${encodeURIComponent('<?php echo $listing_url; ?>')}\n\n
            👤 *Customer Details*\n
            ▫️ Nama: ${encodeURIComponent(formData.name)}\n
            ▫️ WhatsApp: ${encodeURIComponent(formData.phone)}\n
            ▫️ Alamat: ${encodeURIComponent(formData.address)}\n\n
            🕒 *Jadwal Kerja*\n
            ▫️ Metode: ${encodeURIComponent(formData.workflow === 'survei' ? 'Survei Lokasi' : 'Langsung Dikerjakan')}\n
            ▫️ Tanggal: ${encodeURIComponent(formData.date)}\n
            ▫️ Waktu: ${encodeURIComponent(formData.time)}`;

        // Encode message
        const encodedMessage = message.replace(/\n/g, '%0A').replace(/ /g, '%20');
        
        // Redirect ke WhatsApp
        window.open(`https://wa.me/6281236937200?text=${encodedMessage}`, '_blank');
    }
</script>

<?php get_footer(); ?>