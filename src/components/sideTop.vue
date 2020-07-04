<template>
  <div class="side-bar">
    <div >
      <img class="logo" src="img/logo-pfr-blue.jpg">
    </div>
    {{ dT }}
    <div class="profil">
      <img src="img/user.png" />
      <span>{{ userName }}</span>

    </div>
  </div>
</template>

<script>
export default {
  name: 'sideTop',
  data: function() {
    return {
      dT: '',
      userName: '',
    }
  },
  mounted: function() {
    let pointPoint = ':';
    let dateNow = new Date();
    let dd = (+dateNow.getDate() < 10) ? '0' + dateNow.getDate() : dateNow.getDate();
    let mm = (+dateNow.getMonth() < 10) ? '0' + (+dateNow.getMonth() + 1) : +dateNow.getMonth() + 1;
    let yyyy = dateNow.getFullYear();
    let hh = dateNow.getHours();
    let mi = (+dateNow.getMinutes() < 10) ? '0' + dateNow.getMinutes() : dateNow.getMinutes();
    this.dT = dd + '.' + mm + '.' + yyyy + ' ' + hh + ':' + mi;
    setInterval(() => {
      let dateNow = new Date();
      let dd = (+dateNow.getDate() < 10) ? '0' + dateNow.getDate() : dateNow.getDate();
      let mm = (+dateNow.getMonth() < 10) ? '0' + (+dateNow.getMonth() + 1) : +dateNow.getMonth() + 1;
      let yyyy = dateNow.getFullYear();
      let hh = dateNow.getHours();
    let mi = (+dateNow.getMinutes() < 10) ? '0' + dateNow.getMinutes() : dateNow.getMinutes();
    this.dT = dd + '.' + mm + '.' + yyyy + ' ' + hh + pointPoint + mi;
      //this.dT = Date()
    }, 1000);
    setInterval(() => {
      (pointPoint == ':') ? pointPoint = ' ' : pointPoint = ':';
    }, 1000);
  },
  created: function() {
    let request = new XMLHttpRequest();
    request.open('POST', pathBackEnd + 'php/ocenka-user.php', true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.send(``);
    request.onload = () => {
      this.userName = request.response;
      accessUserName = this.userName;
      (this.userName !== 'Гость') ? accessUser = true : accessUser = false;
      this.isLoad = true;
      console.log(request.response);
    }
  }
}
</script>

<style scoped>
.side-bar {
  display: flex;
  margin: 0px 10px;
  align-items: center;
  justify-content: space-between;
  color: white;
}

img {
  width: 40px;
  height: 40px;
  /* margin-left: 5px;*/
  margin-right: 10px; 
}

.logo {
  width: auto;
  height: 48px;
}

.profil {
  display: inline-flex;
  position: relative;
  width: auto;
  min-width: 100px;
  height: 45px;
  padding: 0px 10px;
  border: 0px solid white;
  /* justify-content: space-between; */
  align-items: center;
  color: white;
  /* visibility: hidden; */
}

/*.slide {
  position: absolute;
  display: block;
  width: 150px;
  height: 0px;
  top: 41px;
  left: -1px;
  background-color: white;
  border: 1px solid grey;
  border-radius: 0px 0px 5px 5px;
  box-shadow: 1px 1px 2px grey;
  z-index: 200;
  opacity: 0;
  transition: .5s opacity, .5s height;
  overflow: hidden;
}

.profil:hover > .slide {
  opacity: 1;
  height: 90px;
}*/
</style>