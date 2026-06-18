
const API_URL = "controller/user.php";

async function loadUser() {
  try {
    const res = await fetch(API_URL, { credentials: "include" });

    // لو السيرفر رجّع حاجة مش JSON (صفحة HTML أو 404) نوقف بوضوح
    const text = await res.text();
    let user;
    try {
      user = JSON.parse(text);
    } catch (e) {
      console.error("الرد مش JSON. ده اللي رجع فعلاً:", text.slice(0, 200));
      return;
    }

    // لو المستخدم مش مسجّل دخول
    if (user.error) {
      console.warn("مفيش مستخدم مسجّل:", user.message);
      // ممكن نحوّله لصفحة تسجيل الدخول:
      // window.location.href = "login.php";
      return;
    }

    fillUserData(user);
  } catch (err) {
    console.error("خطأ في الاتصال بالسيرفر:", err);
  }
}

// نملأ بيانات الصفحة بالبيانات الحقيقية
function fillUserData(user) {
  const name  = user.name  || user.username || "User";
  const email = user.email || "";
  const phone = user.phone || "";
  const role  = user.role  || "User";
  const photo = user.image || user.photo || "public/images/default.png";

  // الهيدر فوق
  const welcome = document.querySelector(".header p");
  if (welcome) welcome.textContent = "Welcome back, " + name + "!";

  const adminImg = document.querySelector(".admin-profile img");
  if (adminImg) { adminImg.src = photo; adminImg.onerror = () => adminImg.src = "public/images/default.png"; }
  const adminName = document.querySelector(".admin-profile h3");
  if (adminName) adminName.textContent = name;

  // كارت البروفايل
  const profileImg = document.querySelector(".profile-left img");
  if (profileImg) { profileImg.src = photo; profileImg.onerror = () => profileImg.src = "public/images/default.png"; }

  const profileName = document.querySelector(".name-role h2");
  if (profileName) profileName.textContent = name;
  const profileRole = document.querySelector(".name-role span");
  if (profileRole) profileRole.textContent = role;

  const infoParas = document.querySelectorAll(".profile-info p");
  if (infoParas[0]) infoParas[0].innerHTML = '<i class="fa-regular fa-envelope"></i> ' + email;
  if (infoParas[1]) infoParas[1].innerHTML = '<i class="fa-solid fa-phone"></i> ' + phone;
}

loadUser();