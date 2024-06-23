
const FileInput =()=>{
    document.addEventListener('fil-upload', function(event) {


    const fileGroup = document.querySelector(".upload__group");
    const inputFile = fileGroup?.querySelector("input[type='file']");

    fileGroup?.addEventListener("keypress", e => {
        e.preventDefault()
        const key = e.key || e.keyCode;
        if (key === " " || key === "Enter" || key === 13) {
            e.preventDefault();
            inputFile.click();
        }
    });})
}



export default FileInput
