import axios from 'axios';
import Swal from 'sweetalert2';

axios.defaults.withCredentials = true;

function checkOutPlus(){
  let checkOutBag = document.getElementById('checkOutBag').innerHTML;
  document.getElementById('checkOutBag').innerHTML =Number(checkOutBag)+1;
  Swal.fire({
    title: 'Success',
    text: 'Add one item to checkbox',
    icon: 'success',
    confirmButtonText: 'Cool'
  })
}

let cartButtons = document.getElementsByClassName('checkout-button');

for (let button of cartButtons){
  button.addEventListener('click',function(event) {
    let checkoutId =  event.target.value;
    axios.get('/sanctum/csrf-cookie').then(response => {
      axios.post('/api/checkout', {
          id: checkoutId,
      }).then((responseApi) => {
          if (responseApi.data === 1) {
            checkOutPlus();
          }
      }).catch((error) => {
          console.log(error);
      });
    }).catch(error => console.log(error));
  })
}

let removeCartButtons = document.getElementsByClassName('remove-button');
for(let button of removeCartButtons){
  button.addEventListener('click',(event) => {
    let buttonClicked = event.target;
    buttonClicked.parentElement.parentElement.remove();
    updateCartTotal();
  })
}

let quantityInput = document.getElementsByClassName('cart-quantity-input');
for(let input of quantityInput){
  input.addEventListener('change',(event) => {
    let inputChange = event.target;
    if(isNaN(input.value) || input.value == 0){
      input.value = 1;
    }
    updateCartTotal();
  })
}



function updateCartTotal() {
  let cartItemContainer = document.getElementsByClassName('cart-items')[0];
  let cartRows = cartItemContainer.getElementsByClassName('cart-row');
  let totalPrice = 0;
  for(let cartRow of cartRows){
    let priceElement = cartRow.getElementsByClassName('cart-price')[0];
    let quantityElement = cartRow.getElementsByClassName('cart-quantity-input')[0];
    let price = parseInt(priceElement.innerHTML.replace('Rp.','').replace('.00','').replace(',',''));
    let quantity = parseInt(quantityElement.value);
    totalPrice += price*quantity;
  }
  document.getElementsByClassName('cart-total-price')[0].innerHTML = 'Rp.' + totalPrice.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
}
