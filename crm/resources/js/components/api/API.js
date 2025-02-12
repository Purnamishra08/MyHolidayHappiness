import axios from 'axios';
const API = axios.create({
    baseURL: domain+'/api/',
    publicURL: domain,
    uploadURL: domain+'/uploads/BlogImages',
    frontURL: publicDir+'/admin',
});
API.defaults.headers.common['api-key'] = 'base64:WXqlcIVsOU4o9TfGJcPnB/9yYgSsqIgkaNHOJcJXvRI=';

export default API;