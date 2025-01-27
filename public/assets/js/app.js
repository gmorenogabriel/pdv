function getDate() {
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!
    var yyyy = today.getFullYear();
  
    if(dd<10) {
        dd = '0'+dd
    } 
  
    if(mm<10) {
        mm = '0'+mm
    } 
  
    today = yyyy + '/' + mm + '/' + dd;
    fechahoy= dd + '/' + mm + '/' + yyyy;
    console.log(today);
    console.log(fechahoy);
    document.getElementById("fechahoy").value = fechahoy;
  }
  
  
  window.onload = function() {
    getDate();
  };