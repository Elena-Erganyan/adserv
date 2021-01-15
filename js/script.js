const navBtn = document.getElementById("navBtn");
const closeBtn = document.getElementById("closeBtn");
const categories = document.getElementById("categories");

const onNavBtnClick = () => {
    categories.style.display = "block";
    closeBtn.addEventListener("click", onCloseBtnClick);
};

const onCloseBtnClick = () => {
    categories.style.display = "none";
    closeBtn.removeEventListener("click", onCloseBtnClick);
};

navBtn.addEventListener("click", onNavBtnClick);

function readURL() {
    if (this.files && this.files[0]) {
        const reader = new FileReader();

        reader.onload = (e) => {

            const oImg = document.createElement("img");
            oImg.setAttribute("id", "photo");
            oImg.setAttribute("src", e.target.result);
            oImg.setAttribute("width", 150);
            const preview = document.getElementById("preview");
            preview.appendChild(oImg);

            const btn = document.createElement("button");
            btn.setAttribute("id", "delete");
            btn.setAttribute("type", "button");
            btn.setAttribute("class", "form__btn btn btn--light");
            btn.textContent = "Delete";
            preview.appendChild(btn);

            const imgLabel = document.getElementById("imgLabel");
            imgLabel.classList.add("hidden");

            const del = document.getElementById("delete");
            del.addEventListener("click", onDelClick);
        }

        reader.readAsDataURL(this.files[0]);
    }
}

const onDelClick = () => {
    img.value = "";
    if (del) {
        del.removeEventListener("click", onDelClick);
    }
    preview.innerHTML = "";
    imgLabel.classList.remove("hidden");
};

const img = document.getElementById("img");

if (img) {
    img.addEventListener("change", readURL);
}

const del = document.getElementById("delete");

if (del) {
    del.addEventListener("click", onDelClick);
}