let dropdowns = document.getElementsByClassName('dropdown');
for (let dropdown of dropdowns) {
  let dropdownBtn = dropdown.querySelector('.dropdown-button');
  let dropdownList= dropdown.querySelector('.dropdown-list');

  dropdownBtn.addEventListener('click',(ev) => {
    dropdownList.classList.toggle('hidden');
    dropdownList.classList.toggle('flex');
  });

  document.querySelector('body').addEventListener('click', (event) => {
    if(event.target != dropdown &&  event.target != dropdownList &&  event.target != dropdownBtn){
      dropdownList.classList.remove('flex');
      dropdownList.classList.add('hidden');
    }
  }, true);
}
