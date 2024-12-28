const IncreaseButton = document.querySelector('#increase-seats');
const DecrementButton = document.querySelector("#decrease-seats");
const SeatInput = document.querySelector("#noseats");

IncreaseButton.addEventListener("click", () => {
    if (SeatInput.value === "") {
        SeatInput.value = 1;
    } else {
        SeatInput.value = parseInt(SeatInput.value) + 1;
    }
});

DecrementButton.addEventListener("click", () => {
    if (SeatInput.value === "" || parseInt(SeatInput.value) <= 0) {
        SeatInput.value = 0;
    } else {
        SeatInput.value = parseInt(SeatInput.value) - 1;
    }
});
