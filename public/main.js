new Vue({
  el: "#tracker",
  delimiters: ["${", "}"],
  mounted() {
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
        // Change the color of the checked habit
        let parentElement = element.parentNode;
        parentElement.style.backgroundColor = data.bgColor;
        element.style.color = data.color;
        // Update the count in the badge of the Habit
        weeklyHabitCount = document.getElementById(data.id);
        weeklyHabitCount.innerHTML = data.count;
      }).catch((e) => {
      });
    },
  },
});
