const GET_USER_IP_API_URL = 'https://api.ipify.org/?format=json';

document.addEventListener('DOMContentLoaded', function(){

  const inputs = document.querySelectorAll("input[name='client-ip']");

  if (inputs.length > 0) {
    getUserIP().then((ip) => {
      inputs.forEach((input) => {
        input.value = ip;
      });
    });
  }

});


function getUserIP() {
  return fetch(GET_USER_IP_API_URL).then((response) => response.json()).then((data) => data.ip);
}