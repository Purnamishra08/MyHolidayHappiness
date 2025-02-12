import React, { useEffect,useState } from "react";
import { connect } from "react-redux";
import cookie from 'react-cookies';
import 'antd/dist/antd.css';
import {Link} from 'react-router-dom';
import { LaptopOutlined, NotificationOutlined, UserOutlined,UnorderedListOutlined } from '@ant-design/icons';
import { Breadcrumb, Layout, Menu,Affix } from 'antd';
import { useLocation , useNavigate } from 'react-router-dom';

import API from "../api/API";


export const LoginBody = (props) => {
    const { Header, Content, Footer, Sider } = Layout;

    const navigate = useNavigate();
    const location = useLocation();
    const updateSideBar=()=>{
        // console.log(navigate);
      console.log(location.pathname.replace('/admin',''));
       setCurrentSideber(location.pathname.replace('/admin',''));
      
  }
  const [collapsed, setCollapsed] = useState(false);
  const [currentSideber, setCurrentSideber] = useState('');
    const items =[
      { key:'/categories' ,label: <Link to={API.defaults.frontURL+'/categories'}>Categories</Link>,className: '' },
      { key:'/blogs' ,label: <Link to={API.defaults.frontURL+'/blogs'}>Blogs</Link>,className: '' },
      ];
     let userDetails={};
     var headerItems=[
              {
                key:'login' ,
                label: <Link to={API.defaults.frontURL+'/login'}>Login</Link>,
                className: 'marginLeftAuto', 
              }
            ];
      
    useEffect(()=>{
     
     
   
    updateSideBar();


  },[])
  return (
      <>
        <Layout>
        
          <Header className="header">
            <div className="header-logo">
                <Link to={API.defaults.frontURL}>
                  Logo
                 {/* <img src="/images/logo.png" style={{ width: "100%" }} />*/}
                  {/*<img src="/images/logo1.png" style={{ width: "100%" }} />*/}
                </Link>
               
            </div>
            <Menu theme="dark" mode="horizontal"   defaultSelectedKeys={['/']} items={headerItems} />
          </Header>
          
          <Content
            style={{
              padding: '0 0',
            }}
          >
          
            <Layout
              className="site-layout-background"
            
            >
             
              <Content
                style={{
                  padding: '5%',
                  minHeight: (window.innerHeight-180),
                }}
              >
                {props.children}
              </Content>
            </Layout>
          </Content>
          <Footer
            style={{
              textAlign: 'center',
              backgroundColor:'white'
            }}
          >
            Viral News @2023
          </Footer>
        </Layout>
        
      </>
    );
  
}

const mapStateToProps = (state) => ({});

const mapDispatchToProps = (dispatch) => ({});

export default connect(mapStateToProps, mapDispatchToProps)(LoginBody);
