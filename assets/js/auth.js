document
  .getElementById("signupForm")
  ?.addEventListener("submit", async function (e) {
    e.preventDefault();

    const form = e.target;
    const msg = document.getElementById("formMsg");

    const data = {
      name: form.name.value,
      email: form.email.value,
      password: form.password.value,
      user_type: form.user_type.value,
    };

    msg.innerHTML = "Processing...";

    const res = await fetch("/auth/signup-api.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(data),
    });

    const result = await res.json();

    if (result.status === "success") {
      msg.style.color = "green";
      msg.innerHTML = "Signup successful! Redirecting...";
      setTimeout(() => {
        window.location.href = "/php-dev-marketplace/auth/login.php";
      }, 1500);
    } else {
      msg.style.color = "red";
      msg.innerHTML = result.message;
    }
  });
