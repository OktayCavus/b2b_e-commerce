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
      console.log(result);
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

function profileupdatebutton() {
  document.getElementById("profileupdatebuton").disabled = true;
  // ! id'si bregisterform olan form'un tüm verilerini getirmek için kullanılıyor
  var data = $("#profileupdateform").serialize();

  $.ajax({
    type: "POST",
    url: url + "inc/profileupdate.php",
    data: data,
    success: function (result) {
      console.log(result);
      if ($.trim(result) == "empty") {
        document.getElementById("profileupdatebuton").disabled = false;

        alert("Lütfen boş alan bırakma");
      } else if ($.trim(result) == "format") {
        document.getElementById("profileupdatebuton").disabled = false;

        alert("E posta formatı hatalı");
      } else if ($.trim(result) == "already") {
        document.getElementById("profileupdatebuton").disabled = false;

        alert("bu e-posta adına ait bir bayilik var");
      } else if ($.trim(result) == "error") {
        document.getElementById("profileupdatebuton").disabled = false;

        alert("Bir hata oluştu");
      } else if ($.trim(result) == "ok") {
        alert("Profil başarıyla güncellendi");
        window.location.reload();
      } else {
        document.getElementById("profileupdatebuton").disabled = false;
        alert("var birşeyler");
      }
    },
  });
}

function passwordChangeButton() {
  document.getElementById("passwordChangeButon").disabled = true;
  var data = $("#passwordChangeForm").serialize();

  $.ajax({
    type: "POST",
    url: url + "inc/changepassword.php",
    data: data,
    success: function (result) {
      if ($.trim(result) == "empty") {
        document.getElementById("passwordChangeButon").disabled = false;

        alert("Lütfen boş alan bırakma");
      } else if ($.trim(result) == "match") {
        document.getElementById("passwordChangeButon").disabled = false;

        alert("şifreler uyuşmadı");
      } else if ($.trim(result) == "error") {
        document.getElementById("passwordChangeButon").disabled = false;

        alert("Bir hata oluştu");
      } else if ($.trim(result) == "ok") {
        alert("başarıyla güncellendi");
        window.location.href = url + "/profile.php?process=profile";
      } else {
        alert("var birşeyler");
        document.getElementById("passwordChangeButon").disabled = false;
      }
    },
  });
}

function changeaddressbutton() {
  document.getElementById("changeaddressbuton").disabled = true;
  var data = $("#changeaddresform").serialize();

  $.ajax({
    type: "POST",
    url: url + "inc/addressupdate.php",
    data: data,
    success: function (result) {
      if ($.trim(result) == "empty") {
        document.getElementById("changeaddressbuton").disabled = false;

        alert("Lütfen boş alan bırakma");
      } else if ($.trim(result) == "error") {
        document.getElementById("changeaddressbuton").disabled = false;

        alert("Bir hata oluştu");
      } else if ($.trim(result) == "ok") {
        alert("başarıyla güncellendi");
        window.location.href = url + "/profile.php?process=adress";
      } else {
        alert("var birşeyler");
        document.getElementById("changeaddressbuton").disabled = false;
      }
    },
  });
}

function addNewAddressButton() {
  document.getElementById("addNewAddressButon").disabled = true;
  var data = $("#addNewAddressForm").serialize();

  $.ajax({
    type: "POST",
    url: url + "inc/addNewAddress.php",
    data: data,
    success: function (result) {
      if ($.trim(result) == "empty") {
        document.getElementById("addNewAddressButon").disabled = false;

        alert("Lütfen boş alan bırakma");
      } else if ($.trim(result) == "error") {
        document.getElementById("addNewAddressButon").disabled = false;

        alert("Bir hata oluştu");
      } else if ($.trim(result) == "ok") {
        alert("başarıyla eklendi");
        window.location.href = url + "/profile.php?process=adress";
      } else {
        alert("var birşeyler");
        document.getElementById("addNewAddressButon").disabled = false;
      }
    },
  });
}

function addNewNotifButton() {
  document.getElementById("addNewNotifButon").disabled = true;
  var data = $("#addNewNotifForm").serialize();

  $.ajax({
    type: "POST",
    url: url + "inc/addNewNotif.php",
    data: data,
    success: function (result) {
      if ($.trim(result) == "empty") {
        document.getElementById("addNewNotifButon").disabled = false;

        alert("Lütfen boş alan bırakma");
      } else if ($.trim(result) == "error") {
        document.getElementById("addNewNotifButon").disabled = false;

        alert("Bir hata oluştu");
      } else if ($.trim(result) == "number") {
        document.getElementById("addNewNotifButon").disabled = false;

        alert("Havale tutarı sayısal değer olmalı");
      } else if ($.trim(result) == "ok") {
        alert(
          "Havale bildirimi gönderildi , yönetici kontrolden sonra tarafınıza ulaşım sağlanacaktır"
        );
        window.location.href = url + "/profile.php?process=notification";
      } else {
        alert("var birşeyler");
        document.getElementById("addNewNotifButon").disabled = false;
      }
    },
  });
}
