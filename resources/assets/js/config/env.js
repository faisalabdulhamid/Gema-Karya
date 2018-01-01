export const app_name = document.head.querySelector('meta[name="app-name"]').content
export const base_url = document.head.querySelector('meta[name="base-url"]').content

const url = window.location.pathname
const id = url.split('/')
export const id_detail = id[2]