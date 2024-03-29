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
        window.location.href = url + "login-register";
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
        window.location.href = url + "my-profile";
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
        window.location.href = url + "address";
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
      console.log(result);
      if ($.trim(result) == "empty") {
        document.getElementById("addNewAddressButon").disabled = false;
        alert("Lütfen boş alan bırakmayın.");
      } else if ($.trim(result) == "error") {
        document.getElementById("addNewAddressButon").disabled = false;
        alert("Bir hata oluştu.");
      } else if ($.trim(result) == "ok") {
        alert("Adres başarıyla eklendi.");

        var siparisBilgileri = {
          isimSoyisim: $("input[name='name']").val(),
          telefon: $("input[name='phone']").val(),
          siparisNotu: $("textarea[name='note']").val(),
        };

        var currentURL = window.location.href;

        if (currentURL.indexOf("new-address") !== -1) {
          window.location.reload();
        } else {
          window.location.reload();

          $("input[name='name']").val(siparisBilgileri.isimSoyisim);
          $("input[name='phone']").val(siparisBilgileri.telefon);
          $("textarea[name='note']").val(siparisBilgileri.siparisNotu);
        }
      } else {
        alert("Bir şeyler ters gitti.");
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
        window.location.href = url + "notification";
      } else {
        alert("var birşeyler");
        document.getElementById("addNewNotifButon").disabled = false;
      }
    },
  });
}

function addNewComment() {
  document.getElementById("addNewComentButon").disabled = true;
  var data = $("#commentform").serialize();

  $.ajax({
    type: "POST",
    url: url + "/inc/addNewComment.php",
    data: data,
    success: function (result) {
      if ($.trim(result) == "empty") {
        document.getElementById("addNewComentButon").disabled = false;

        alert("Lütfen boş alan bırakma");
      } else if ($.trim(result) == "error") {
        document.getElementById("addNewComentButon").disabled = false;

        alert("Bir hata oluştu");
      } else if ($.trim(result) == "char") {
        document.getElementById("addNewComentButon").disabled = false;

        alert("Yorumunuz en az 200 karakter olmalıdır!.");
      } else if ($.trim(result) == "ok") {
        alert(
          "Yorumunuz gönderildi , yönetici kontrolden sonra yayınlanacaktır."
        );
        window.location.reload();
      } else {
        alert("var birşeyler");
        console.log(result);
        document.getElementById("addNewComentButon").disabled = false;
      }
    },
  });
}

function sendMessage() {
  document.getElementById("sendMessageButton").disabled = true;
  var data = $("#contactform").serialize();

  $.ajax({
    type: "POST",
    url: url + "/inc/sendMessage.php",
    data: data,
    success: function (result) {
      if ($.trim(result) == "empty") {
        document.getElementById("sendMessageButton").disabled = false;
        alert("Lütfen boş alan bırakma");
      } else if ($.trim(result) == "error") {
        document.getElementById("sendMessageButton").disabled = false;
        alert("Bir hata oluştu");
      } else if ($.trim(result) == "format") {
        document.getElementById("sendMessageButton").disabled = false;
        alert("E posta formatı hatalı");
      } else if ($.trim(result) == "char") {
        document.getElementById("sendMessageButton").disabled = false;
        alert("Mesajınız en az 100 karakter olmalıdır!.");
      } else if ($.trim(result) == "ok") {
        alert("Mesajınız gönderildi , en kısa sürede dönüş sağlanacaktır ! .");
        window.location.href = url + "thank-you";
      } else {
        alert("var birşeyler");
        console.log(result);
        document.getElementById("sendMessageButton").disabled = false;
      }
    },
  });
}

function addCart() {
  document.getElementById("addCartt").disabled = true;
  var data = $("#addCartForm").serialize();

  $.ajax({
    type: "POST",
    url: url + "/inc/addCart.php",
    data: data,
    success: function (result) {
      console.log(result);
      if ($.trim(result) == "empty") {
        alert("Ürün adeti belirtiniz");
        document.getElementById("addCartt").disabled = false;
      } else if ($.trim(result) == "login") {
        alert("Sepete eklemek için giriş yapmalısınız");
        document.getElementById("addCartt").disabled = false;
      } else if ($.trim(result) == "qty") {
        alert("En az 1 adet seçmelisiniz");
        document.getElementById("addCartt").disabled = false;
      } else if ($.trim(result) == "error") {
        alert("Hata oluştu");
        document.getElementById("addCartt").disabled = false;
      } else if ($.trim(result) == "ok") {
        alert("Ürün sepete eklendi");
        document.getElementById("addCartt").disabled = false;

        window.location.reload();
      } else {
        alert("var birşeyler");
        document.getElementById("addCartt").disabled = false;
      }
    },
  });
}

function ordercompleted() {
  document.getElementById("ordercomplet").disabled = true;
  var data = $("#orderform").serialize();

  $.ajax({
    type: "POST",
    url: url + "/inc/newOrder.php",
    data: data,
    success: function (result) {
      console.log(result);
      if ($.trim(result) == "empty") {
        document.getElementById("ordercomplet").disabled = false;

        alert("Lütfen boş alan bırakma");
      } else if ($.trim(result) == "error") {
        document.getElementById("ordercomplet").disabled = false;

        alert("Bir hata oluştu");
      } else if ($.trim(result) == "ok") {
        alert("Siparişiniz için teşekkür ederiz.");
        window.location.href = url + "order-complete";
      } else {
        alert("var birşeyler");
        console.log(result);
        document.getElementById("ordercomplet").disabled = false;
      }
    },
  });
}

function forgetbutton() {
  var data = $("#forgetpasswordform").serialize();
  document.getElementById("forgetbuton").disabled = true;

  $.ajax({
    type: "POST",
    url: url + "/inc/forgetpassword.php",
    data: data,
    success: function (result) {
      console.log(result);
      if ($.trim(result) == "empty") {
        document.getElementById("forgetbuton").disabled = false;

        alert("Boş alan bırakma");
      } else if ($.trim(result) == "error") {
        document.getElementById("forgetbuton").disabled = false;

        alert("Bu bilgilere ait bayi bulunmuyor");
      } else if ($.trim(result) == "ok") {
        document.getElementById("forgetbuton").disabled = false;

        alert("Şifre sıfırlama linki mail adresinize gönderildi");
        window.location.href = url;
      }
    },
  });
}

function forgetbutton2() {
  var data = $("#forgetpasswordform2").serialize();
  document.getElementById("forgetbuton2").disabled = true;

  $.ajax({
    type: "POST",
    url: url + "/inc/recoverypassword.php",
    data: data,
    success: function (result) {
      console.log(result);
      if ($.trim(result) == "empty") {
        document.getElementById("forgetbuton2").disabled = false;

        alert("Boş alan bırakma");
      } else if ($.trim(result) == "error") {
        document.getElementById("forgetbuton2").disabled = false;

        alert("Bu sıfırlama koduna ait veri bulunmuyor");
      } else if ($.trim(result) == "ok") {
        alert("Şifreniz başarıyla sıfırlandı");
        window.location.href = url + "/login-register";
      }
    },
  });
}
