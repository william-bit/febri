import Swal from 'sweetalert2';
function fireSuccess(msg){
    Swal.fire({
        title: 'Success',
        text: msg,
        icon: 'success',
        confirmButtonText: 'Cool'
      })
}
function fireError(msg){
    Swal.fire({
        title: 'Error',
        text: msg,
        icon: 'Error',
        confirmButtonText: 'Cool'
      })
}

function startFire() {
    const urlParams = new URLSearchParams(window.location.search);
    const msg = urlParams.get('msg');
    const type = urlParams.get('fire');
    if(type == 'success'){
        fireSuccess(msg);
    }else if (type == 'error'){
        fireError(msg);
    }
}

startFire();
