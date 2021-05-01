import axios from 'axios';
axios.defaults.withCredentials = true;

function checkOutPlus(){
  let checkOutBag = document.getElementById('checkOutBag').innerHTML;
  document.getElementById('checkOutBag').innerHTML =Number(checkOutBag)+1;
}

let cartButton = document.getElementsByClassName('checkout-button');

for (let i = 0; i < cartButton.length;i++){
  let button = cartButton[i];
  button.addEventListener('click',function(event) {
    let checkoutId =  event.target.value;
    axios.get('/sanctum/csrf-cookie').then(response => {
      axios.post('api/checkout', {
          id: checkoutId,
      }).then((response) => {
          if (response.data === 1) {
            checkOutPlus();
          }
      }).catch((error) => {
          console.log(error);
      });
    }).catch(error => console.log(error));
  })
}
