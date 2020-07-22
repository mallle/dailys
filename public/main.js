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
      let element = e.target;
      let url = element.getAttribute('data-url');
      axios({
        method: "post",
        url: url,
      }).then((response) => {
        let data = response.data;
        let parentElement = element.parentNode;
        parentElement.style.backgroundColor = data.bgColor;
        element.style.color = data.color;
      }).catch((e) => {
      });
    },
  },
});
