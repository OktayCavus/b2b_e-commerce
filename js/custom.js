var url = "http://localhost/B2B_commerce/";

function registerbutton() {
  document.getElementById("registerbuton").disabled = true;
  // ! id'si bregisterform olan form'un tüm verilerini getirmek için kullanılıyor
  var data = $("#bregisterform").serialize();

  $.ajax({
    type: "POST",
    url: url + "inc/register.php",
    data: data,
    success: function (result) {
      console.log(result);
      if ($.trim(result) == "empty") {
        document.getElementById("registerbuton").disabled = false;

        alert("Lütfen boş alan bırakma");
      } else if ($.trim(result) == "format") {
        document.getElementById("registerbuton").disabled = false;

        alert("E posta formatı hatalı");
      } else if ($.trim(result) == "match") {
        document.getElementById("registerbuton").disabled = false;

        alert("şifreler uyuşmadı");
      } else if ($.trim(result) == "already") {
        document.getElementById("registerbuton").disabled = false;

        alert("bu e-posta adına ait bir bayilik var");
      } else if ($.trim(result) == "error") {
        document.getElementById("registerbuton").disabled = false;

        alert("Bir hata oluştu");
      } else if ($.trim(result) == "ok") {
        alert("başarıyla oluşturuldu yönetici onayından sonra aktifleşecek");
        window.location.href = url;
      } else {
        alert("var birşeyler");
      }
    },
  });
}

function loginbutton() {
  var data = $("#bloginform").serialize();
  document.getElementById("registerbuton").disabled = true;

  $.ajax({
    type: "POST",
    url: url + "inc/login.php",
    data: data,
    success: function (result) {
      if ($.trim(result) == "empty") {
        document.getElementById("registerbuton").disabled = false;

        alert("Boş alan bırakma");
      } else if ($.trim(result) == "error") {
        document.getElementById("registerbuton").disabled = false;

        alert("Bayi kodu , eposta veya şifre yanlış");
      } else if ($.trim(result) == "passive") {
        document.getElementById("registerbuton").disabled = false;

        alert("Üyeliğiniz pasif durumdadır");
      } else if ($.trim(result) == "ok") {
        alert("başarıyla giriş yapıldı");
        window.location.href = url;
      }
    },
  });
}
