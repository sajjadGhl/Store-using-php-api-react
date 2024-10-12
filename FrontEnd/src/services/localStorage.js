const setLocalStorage = (key, value) => {
    localStorage.setItem(key, JSON.stringify(value));
}
const getLocalStorage = (key) => {
    return JSON.parse(localStorage.getItem(key));
}
const deleteLocalStorage = (key) => {
    localStorage.removeItem(key);
}

export { setLocalStorage, getLocalStorage, deleteLocalStorage };