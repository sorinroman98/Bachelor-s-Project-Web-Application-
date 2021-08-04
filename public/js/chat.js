const form = document.querySelector(".typing-area"),
    input = form.querySelector(".input-field"),
    sendButton = form.querySelector("button");
    chatTextBox = document.querySelector(".chat-box");


form.onsubmit = (e)=>{
    e.preventDefault();
}

sendButton.addEventListener("click",()=>{

    let xmlHttpRequest = new XMLHttpRequest();
    xmlHttpRequest.open("POST","http://localhost/Licenta/chat/insertChat",true);
    xmlHttpRequest.onload = ()=>{
        if(xmlHttpRequest.readyState === XMLHttpRequest.DONE){
            if(xmlHttpRequest.status === 200){
                input.value = "";
                scrollBottom();
            }
        }
    }
    let data = new FormData(form);
    xmlHttpRequest.send(data);
})

chatTextBox.onmouseenter = ()=>{
    chatTextBox.classList.add("active");
}

chatTextBox.onmouseleave = ()=>{
    chatTextBox.classList.remove("active");
}

setInterval(() =>{

    let xmlHttpRequest = new XMLHttpRequest();
    xmlHttpRequest.open("POST","http://localhost/Licenta/chat/getChat",true);
    xmlHttpRequest.onload = ()=>{
        if(xmlHttpRequest.readyState === XMLHttpRequest.DONE){
            if(xmlHttpRequest.status === 200){
                let data = xmlHttpRequest.response;
                chatTextBox.innerHTML = data;
                if(!chatTextBox.classList.contains("active")){
                    scrollBottom();
                }
            }
        }
    }
    let data = new FormData(form);
    xmlHttpRequest.send(data);

}, 500);

function scrollBottom(){
    chatTextBox.scrollTop = chatTextBox.scrollHeight;
}