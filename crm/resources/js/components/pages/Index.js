import React,{useEffect} from 'react'
import cookie from 'react-cookies';
import { useNavigate } from 'react-router-dom';
import API from "../api/API";

export default function Index() {
 const userDetails=cookie.load('userDetails'); 
 const navigate = useNavigate();

    useEffect(() => {
      if(!userDetails){
           navigate(API.defaults.frontURL+'/login');
         }else{
          navigate(API.defaults.frontURL+'/blogs');
         }
       },[])
  return (
    <div></div>
  )
}
