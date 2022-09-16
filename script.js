document.addEventListener('DOMContentLoaded', function(){

  const inputs = document.querySelectorAll("input[name='client-ip']");
  console.log("inputs", inputs);

  getUserIP().then((ip) => {
    inputs.forEach((input) => {
      input.value = ip;
    });
  })


});


function getUserIP() {
  return fetch('https://api.ipify.org/?format=json').then((response) => response.json()).then((data) => data.ip);
}