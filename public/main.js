new Vue({
  el: "#tracker",
  delimiters: ["${", "}"],
  created() {
    let date = new Date();
    document.getElementById("" + date.getDate()).scrollIntoView({
      behavior: "smooth",
    });
  },
  methods: {
    checkHabit: function (e) {
      let element = e.path[0];
      let url = element.attributes["data-url"].nodeValue;
      axios({
        method: "post",
        url: url,
      }).then((response) => {
        let data = response.data;
        let parentElement = element.parentNode;
        parentElement.style.backgroundColor = data.bgColor;
        element.style.color = data.color;
        element.innerHTML ='fehler!';
      }).catch((e) => {
        element.innerHTML = 'fehler!';
      });
    },
  },
});
