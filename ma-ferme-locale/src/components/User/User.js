class User {

    constructor() {
        this.init()
    }

    init() {
        this.id = Number(localStorage.getItem('userId'))
        this.firstName = localStorage.getItem('userFirstName')
        this.loggedIn = localStorage.getItem('userLoggedIn')
        this.token = localStorage.getItem('userToken')
    }

    /**
     *
     * @param data object
     * @param data.name string
     * @param data.email string
     * @param callback function
     */
    authenticated(data, callback) {
        localStorage.setItem('userId', data.data.id)
        localStorage.setItem('userFirstName', data.data.first_name)
        localStorage.setItem('userLoggedIn', true)
        localStorage.setItem('userToken', data.data.token)

        this.init()

        callback()
    }

    /**
     *
     * @return {boolean}
     */
    isLoggedIn() {
        return Boolean(this.loggedIn) === true
    }

    /**
     * Remove all user's data from local storage
     */
    destroy() {
        localStorage.removeItem('userId')
        localStorage.removeItem('userFirstName')
        localStorage.removeItem('userLoggedIn')
        localStorage.removeItem('userToken')
    }

    /**
     *
     * @param callback function
     */
    logout(callback) {
        this.destroy()

        callback()
    }
}

export default new User()