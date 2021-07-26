import Swal from 'sweetalert2';
function capitalizeFirstLetter(string) {
  return string.charAt(0).toUpperCase() + string.slice(1);
}
function fire(msg,type,title){
    Swal.fire({
        title: title,
        text: msg,
        icon: type,
        confirmButtonText: 'Cool'
      })
}
function startFire() {
    const urlParams = new URLSearchParams(window.location.search);
    const msg = urlParams.get('msg');
    const type = urlParams.get('fire');
    const title = (urlParams.get('title'))?urlParams.get('title'):capitalizeFirstLetter(type);
    const fires = ["success", "error", "warning"];
    if(fires.includes(type)){
        fire(msg,type,title);
    }
}

startFire();
