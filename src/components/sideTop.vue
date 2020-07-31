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
      arrUser: Array,
      userName: '',
    }
  },
  mounted: function() {
    let pointPoint = ':';
    setInterval(() => {
      let dateNow = new Date();
      let dd = (+dateNow.getDate() < 10) ? '0' + dateNow.getDate() : dateNow.getDate();
      let mm = (+dateNow.getMonth() < 10) ? '0' + (+dateNow.getMonth() + 1) : +dateNow.getMonth() + 1;
      let yyyy = dateNow.getFullYear();
      let hh = dateNow.getHours();
    let mi = (+dateNow.getMinutes() < 10) ? '0' + dateNow.getMinutes() : dateNow.getMinutes();
    this.dT = dd + '.' + mm + '.' + yyyy + ' ' + hh + pointPoint + mi;
    }, 1000);
    setInterval(() => {
      (pointPoint == ':') ? pointPoint = ' ' : pointPoint = ':';
    }, 1000);
  },
  created: function() {
    let request = new XMLHttpRequest();
    request.open('POST', pathBackEndrep + 'php/ocenka/ocenka.php', true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.responseType = 'json';
    request.send(`function=getUser`);
    request.onload = () => {
      this.arrUser = request.response;
      if (this.arrUser.length) {
        accessUser = true;
        accessUserId = this.arrUser[0].ID;
        this.userName = this.arrUser[0].CNAME;
        if (this.userName[0] == '$') accessUserAdmin = true;
      } else {
        accessUser = false;
        this.userName = 'Гость';
      }
      this.isLoad = true;
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
  align-items: center;
  color: white;
}

</style>