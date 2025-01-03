const toastTrigger = document.getElementById("liveToastBtn")
const toastLiveexample = document.getElementById("liveToast")
if (toastTrigger) {
  toastTrigger.addEventListener("click", () => {
    const toast = new bootstrap.Toast(toastLiveexample)

    toast.show()
  })
}
