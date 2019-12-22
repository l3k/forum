export function login(credentials) {
    return new Promise((resolve, reject) => {
        axios.post('/api/auth/login', credentials)
            .then((response) => {
                resolve(response.data)
            })
            .catch((error) => {
                reject(error)
            })
    })
}

export function register(credentials) {
    return new Promise((resolve, reject) => {
        axios.post('/api/auth/register', credentials)
            .then((response) => {
                resolve(response.data)
            })
            .catch(({ response }) => {
                console.log(response)
                reject(response.data.error)
            })
    })
}

export function getLocalUser() {
    const user = localStorage.getItem("user");

    if(!user) {
        return null
    }

    return JSON.parse(user)
}