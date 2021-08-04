const searchBar = document.querySelector(".users .search input"),
      userList = document.querySelector(".users .users-list"),
      searchBtn = document.querySelector(".users .search button");


searchBtn.addEventListener("click",()=>{

    searchBar.classList.toggle("active");
    searchBar.focus();
    searchBtn.classList.toggle("active");
})

let searchTerm = "";
searchBar.addEventListener("keyup",(e)=>{
    searchTerm = e.target.value;

})

setInterval(() =>{

    let xhr = new XMLHttpRequest();
    xhr.open("GET","http://localhost/Licenta/chat/curentChat?q="+ searchTerm,true);
    xhr.onload = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                let data = xhr.response;
                userList.innerHTML = data;
            }
        }
    }
    xhr.send();


}, 500);

