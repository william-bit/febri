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

    axios.get('/sanctum/csrf-cookie').then(response => {
      axios.get('/api/search',{
        params: {
          search: searchValue
        }
      }).then(response => {
        if(response.data){
          suggestion = response.data[0];
          if(searchValue){
            emptyArray = suggestion.filter((data)=>{
              return data.name.toLocaleLowerCase().includes(searchValue.toLocaleLowerCase());
            })
            emptyArray = emptyArray.map((data)=>{
              return data = `<li class="hover:bg-gray-200" >${data.name}</li>`;
            })
            suggestionBox.classList.remove('hidden');
            showSuggestion(emptyArray);
            let allList = suggestionBox.querySelectorAll("li");
            for(let i=0;i<allList.length;i++){
              allList[i].setAttribute("onclick","selectSuggest(this)")
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
