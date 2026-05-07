document
.getElementById("bmiForm")
.addEventListener("submit", function(event) {

    const age = document.querySelector("[name='age']").value;
    const weight = document.querySelector("[name='weight']").value;
    const height = document.querySelector("[name='height']").value;

    if(age <= 0 || weight <= 0 || height <= 0) {

        alert("Please enter valid positive numbers.");

        event.preventDefault();
    }
});