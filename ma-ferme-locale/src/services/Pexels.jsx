const API_KEY = process.env.REACT_APP_PEXELS_API_KEY;

async function getPhotos(id) {
    // fetch a photos with the given id from the API using fetch
    const response = await fetch(`https://api.pexels.com/v1/photos/${id}`, {
        headers: {
            Authorization: `${API_KEY}`
        }
    });
    // return the photo object
    return await response.json();
}

async function getVideos(id) {
    // fetch a videos with the given id from the API using fetch
    const response = await fetch(`https://api.pexels.com/videos/videos/${id}`, {
        headers: {
            Authorization: `${API_KEY}`
        }
    });
    // return the photo object
    return await response.json();
}

export { getPhotos, getVideos };