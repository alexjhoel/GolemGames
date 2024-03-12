var switches = document.querySelectorAll('[data-bs-theme-value]')



const getStoredTheme = () => {
    const storedTheme = getTheme()
    if (storedTheme) {
      return storedTheme
    }

    return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'
}

const getTheme = () => {
    return localStorage.getItem("color-theme")
}

const setTheme = theme => {
    document.documentElement.setAttribute("data-bs-theme", theme)

    localStorage.setItem("color-theme", theme)
}

const disableAllSwitches = () => {
    switches.forEach(element => {
        element.classList.remove('active')
        element.setAttribute('aria-pressed', 'false')
    })
}

setTheme(getStoredTheme())

switches.forEach(element => {
    element.addEventListener('click', () => {
        disableAllSwitches()
        setTheme(element.getAttribute("data-bs-theme-value"))
        element.classList.add("active")
    })
    if(element.getAttribute("data-bs-theme-value") == getStoredTheme()) element.classList.add("active")
})

