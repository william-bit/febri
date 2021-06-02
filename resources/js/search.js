import axios from 'axios';

let searchBox = document.getElementById('search-box');
let inputBox = searchBox.querySelector('input');
let suggestionBox = document.getElementById('suggest-box');
let suggestion = [];

let timeout = null;
let searchValue = '';
inputBox.onkeyup = (e) =>{
  clearTimeout(timeout);
  timeout = setTimeout(() => {
    searchValue = e.target.value;
    let emptyArray = [];

    axios.get(APP_URL+'/sanctum/csrf-cookie').then(response => {
      axios.get(APP_URL+'/api/search',{
        params: {
          search: searchValue
        }
      }).then(responseApi => {
        if(responseApi.data){
          suggestion = responseApi.data[0];
          if(searchValue){
            emptyArray = suggestion.filter((data)=>{
              return data.name.toLocaleLowerCase().includes(searchValue.toLocaleLowerCase());
            })
            emptyArray = emptyArray.map((data)=>{
              return `<li class="hover:bg-gray-200" >${data.name}</li>`;
            })
            suggestionBox.classList.remove('hidden');
            showSuggestion(emptyArray);
            let allLists = suggestionBox.querySelectorAll("li");
            for(let allList of allLists){
              allList.setAttribute("onclick","selectSuggest(this)")
            }
          }else{
            suggestionBox.classList.add('hidden');
          }
        }else{
          suggestion = [];
        }
      }).catch(error => console.log(error));
    }).catch(error => console.log(error));
  }, 300);
}

function showSuggestion(list){
  let listData;
  if(!list.length){
    listData = '';
  }else{
    listData = list.join('');
  }
  suggestionBox.innerHTML = listData;
}
