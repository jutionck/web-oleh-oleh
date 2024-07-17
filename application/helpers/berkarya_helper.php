<?php

function pageOfficial($page = "", $data = array())
{
	$ci = &get_instance();
	$ci->load->view('official/template/header', $data);
	$ci->load->view($page, $data);
	$ci->load->view('official/template/footer', $data);
}

function pageAuth($page = "", $data = array())
{
	$ci = &get_instance();
	$ci->load->view('backoffice/auth/header', $data);
	$ci->load->view($page, $data);
	$ci->load->view('backoffice/auth/footer', $data);
}

function pageBackend($page = '', $data = array())
{
	$ci = &get_instance();
	$ci->load->view('backoffice/template/header', $data);
	$ci->load->view('backoffice/template/sidebar', $data);
	$ci->load->view('backoffice/template/topbar', $data);
	$ci->load->view($page, $data);
	$ci->load->view('backoffice/template/footer', $data); // Pastikan `$data` di-pass jika diperlukan
}


function keyencrypt()
{
	return '123Daftar@@';
}

function encodeEncrypt($id)
{
	$cleanId = preg_replace('/[^A-Za-z0-9\-_~]/', '', $id);
	return str_replace(array('+', '/', '='), array('-', '_', '~'), base64_encode($cleanId));
}

function decodeEncrypt($id)
{
	return base64_decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $id));
}

function sessionAdmin($role)
{
	$ci = get_instance();
	return $ci->session->userdata($role);
}

function cek_login($role = null)
{
	$ci = get_instance();
	if (!$ci->session->userdata('username')) {
		$ci->session->set_userdata('redirect_back', current_url());
		redirect('backoffice');
	}

	if ($role) {
		$sessionActive = $ci->session->userdata('username');
		if ($sessionActive->role != $role) {
			redirect('backoffice');
		}
	}
}

function calculateAge($birthDate)
{
	$birthDate = new DateTime($birthDate);
	$today = new DateTime("today");
	if ($birthDate > $today) {
		exit("0 tahun 0 bulan 0 hari");
	}
	$y = $today->diff($birthDate)->y;
	$m = $today->diff($birthDate)->m;
	$d = $today->diff($birthDate)->d;
	return $y . " tahun " . $m . " bulan " . $d . " hari";
}

function indonesianDate($date, $format)
{
	// 'dddd, D MMMM Y, HH:mm' => Selasa, 8 Februari 2022, 14:00
	$date = \Carbon\Carbon::parse($date, 'UTC')->locale('id');
	return $date->isoFormat($format);
}

function getTextPeriod($date)
{
	$today = date('Y-m-d');
	if ($today <= $date) {
		return '<span class="badge bg-success">Open</span>';
	} else {
		return '<span class="badge bg-danger">Closed</span>';
	}
}

function strContains($text, $needle)
{
	return str_contains($text, $needle);
}

function emailBody()
{
	$body = "";
	return $body;
}

function newSlug($data)
{
	$slug = url_title($data, 'dash', TRUE);
	return $slug;
}

function removeDots($data)
{
	return str_replace('.', '', $data);
}

function convertCurrencyIDRToNumber($currency)
{
	$cleanString = str_replace("Rp. ", "", $currency);
	$cleanString = str_replace(".", "", $cleanString);

	return (int)$cleanString;
}

function createWhatsappLink($name, $phoneNumber, $total, $bank, $registrantKey, $status)
{
	$totalFormatted = number_format($total, 0, ',', '.');
	$phoneNumberInternational = preg_replace("/^0/", "62", $phoneNumber);
	$message = "";

	if ($status === 'pending') {
		$message = "Hai, *$name*\n\n"
			. "Selamat, Anda telah terdaftar pada kegiatan PITHOGSI 2024. Anda memiliki tagihan sebesar Rp$totalFormatted.\n\n"
			. "Lakukan transfer:\n\n"
			. "Bank Transfer/ATM Ke:\n"
			. "{$bank->name} Cabang {$bank->branch}\n"
			. "No. {$bank->number}\n"
			. "Atas Nama: {$bank->account_name}\n\n"
			. "Unduh Invoice: https://registration.pithogsi16.com/invoice/$registrantKey\n\n"
			. "Note: Konfirmasi bukti pembayaran ke email *registrasi@pithogsi16.com* atau WA *081282868612* atau upload bukti pembayaran di website resmi https://pithogsi16.com/registrasi.html untuk mendapatkan validasi pembayaran.";
	} elseif ($status === 'paid') {
		$message = "Hai, *$name*\n\n"
			. "Berikut adalah bukti konfirmasi validasi pembayaran PIT HOGSI 16\n\n"
			. "Unduh Bukti Pembayaran: https://registration.pithogsi16.com/payment/$registrantKey\n\n"
			. "Note: Simpan bukti ini untuk konfirmasi kehadiran saat acara (offline).";
	} elseif ($status === 'underpaid') {
		$message = "Hai, *$name*\n\n"
			. "Berikut adalah bukti konfirmasi validasi pembayaran PIT HOGSI 16\n\n"
			. "Unduh Bukti Pembayaran: https://registration.pithogsi16.com/payment/$registrantKey\n\n"
			. "Note: Mohon melakukan sisa pembayaran agar terdaftar sebagai peserta PIT HOGSI 16. Upload bukti pembayaran di website resmi https://pithogsi16.com/registrasi.html";
	}

	$messageEncoded = urlencode($message);
	$destinationNumber = $phoneNumberInternational;

	return "https://wa.me/$destinationNumber?text=$messageEncoded";
}


function generateQRCode($data)
{

	$ci = get_instance();
	$ci->load->library('ciqrcode');
	$config['cacheable']  = true;
	$config['cachedir']   = './assets/';
	$config['errorlog']   = './assets/';
	$config['imagedir']   = './assets/qrcode/';
	$config['quality']    = true;
	$config['size']       = '1024';
	$config['black']      = array(224, 255, 255);
	$config['white']      = array(70, 130, 180);
	$ci->ciqrcode->initialize($config);
	$image_name = $data . '.png';

	$params['data'] = $data;
	$params['level'] = 'H';
	$params['size'] = 10;
	$params['savename'] = FCPATH . $config['imagedir'] . $image_name;
	$ci->ciqrcode->generate($params);
	return $image_name;
}


function load_env()
{
	$dotenv_path = FCPATH . '.env';
	if (file_exists($dotenv_path)) {
		$lines = file($dotenv_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
		foreach ($lines as $line) {
			if (strpos(trim($line), '#') === 0) {
				continue;
			}
			list($name, $value) = explode('=', $line, 2);
			$name = trim($name);
			$value = trim($value);
			if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
				putenv(sprintf('%s=%s', $name, $value));
				$_ENV[$name] = $value;
				$_SERVER[$name] = $value;
			}
		}
	}
}
