// import React from "react";
import { BrowserRouter as Router, HashRouter, Routes, Route } from "react-router-dom";

import "bootstrap/dist/css/bootstrap.min.css";
import "./scss/main.scss";
import PageNotFound from './pages/PageNotFound';
import Blogs from './pages/Blog/Blogs';
import AddBlog from './pages/Blog/AddBlog';
import EditBlog from './pages/Blog/EditBlog';

import Categories from './pages/Category/Categories';
import AddCategory from './pages/Category/AddCategory';
import EditCategory from './pages/Category/EditCategory';
import Index from './pages/Index';
import Login from './pages/Login';

import API from "./api/API";

export default function App() {
    return (
        <>
            <Router >
                <Routes>
                    <Route path={API.defaults.frontURL+"/blogs"} element={<Blogs />} />
                    <Route path={API.defaults.frontURL+"/addBlog"} element={<AddBlog />} />
                    <Route path={API.defaults.frontURL+"/editBlog"} element={<EditBlog />} />


                    <Route path={API.defaults.frontURL+"/categories"} element={<Categories />} />
                    <Route path={API.defaults.frontURL+"/addCategory"} element={<AddCategory />} />
                    <Route path={API.defaults.frontURL+"/editCategory"} element={<EditCategory />} />
                    <Route path={API.defaults.frontURL+"/"} element={<Index />} />
                    <Route path={API.defaults.frontURL+"/login"} element={<Login />} />

                    <Route path="*" element={<PageNotFound />} />
                </Routes>
            </Router>
        </>
    );
}


//FIXED RESPONSIVE ISSUES
//FIXED USER API CALL AGAIN AND AGAIN
