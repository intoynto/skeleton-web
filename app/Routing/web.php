<?php
declare (strict_types=1);

use Intoy\HebatApp\Route;

Route::get("/",'WebAction@home')->setName('home');

/*
// ======= AUTH sign
Route::get("/auth",'AuthAction@loginForm')->setName('auth.sign.in');
Route::post("/auth",'AuthAction@loginAction');
// ======= AUTH singup
Route::get("/auth/sign-up",'AuthAction@registerForm')->setName('auth.sign.up');
Route::post("/auth/sign-up",'AuthAction@registerAction');

// ======= AUTH signup OTP
Route::get("/auth/otp/{b64}",'AuthAction@otpForm')->setName("auth.otp.form");
Route::post("/auth/otp/{b64}",'AuthAction@otpAction');
Route::get("/auth/otp-resend/{b64}",'AuthAction@otpResend')->setName("auth.otp.resend");
// ======= AUTH registered
Route::get("/auth/registered/{id_user}",'AuthAction@sudahTerdaftar')->setName("auth.registered");
// ======= AUTH sing-out
Route::get("/auth/sign-out",'AuthAction@keluar')->setName('auth.sign.out');

// auth ganti tahun
Route::get("/auth/switch-tahun","AuthAction@gantiTahunForm")->setName('auth.ganti.tahun');
Route::post("/auth/switch-tahun","AuthAction@gantiTahunAction");

// auth recovery request action
Route::get("/auth/recovery",'AuthAction@recoveryForm')->setName('auth.recovery');
Route::post("/auth/recovery",'AuthAction@recoveryAction');

// auth reset and reset-action
Route::get("/auth/reset-long/{id_user}/{recovery_key}",'AuthAction@resetLongForm')->setName('auth.reset.long');
Route::post("/auth/reset-long/{id_user}/{recovery_key}",'AuthAction@resetLongAction');
Route::get("/auth/reset-success/{id_user}",'AuthAction@resetSuccess')->setName("auth.reset.success");

*/

Route::get("/ws-test",'WsTestAction@action')->setName("ws.test");