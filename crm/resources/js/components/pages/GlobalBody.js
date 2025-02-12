import React, { useEffect,useState } from "react";
import { connect } from "react-redux";
import cookie from 'react-cookies';
import 'antd/dist/antd.css';
import {Link} from 'react-router-dom';
import { LaptopOutlined, NotificationOutlined, UserOutlined,UnorderedListOutlined } from '@ant-design/icons';
import { Breadcrumb, Layout, Menu,Affix } from 'antd';
import { useLocation , useNavigate } from 'react-router-dom';

import API from "../api/API";


export const GlobalBody = (props) => {
    const { Header, Content, Footer, Sider } = Layout;

    const navigate = useNavigate();
    const location = useLocation();
    const updateSideBar=()=>{
        // console.log(navigate);
      console.log(location.pathname.replace('/admin',''));
       setCurrentSideber(location.pathname.replace('/admin',''));
      
  }
  const handleLogout=()=>{
      cookie.remove('userDetails');
      userDetails={};
      
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
                label: <Link to={API.defaults.frontURL+'/login'} onClick={()=>handleLogout()}>Logout</Link>,
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
              <Sider
                  width={165}
                  style={{
                    background: 'white',
                    borderTop: 'solid 1px #405176 ',
                    borderBottom: 'solid 1px #405176 ',
                  }}
                >
                  <Menu
                    mode="inline"
                    defaultSelectedKeys={[currentSideber]}
                    style={{
                      height: '100vh',
                      borderRight: 0,
                      padding:'20px 0'
                    }}
                    items={items}
                  />
                </Sider>   
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

export default connect(mapStateToProps, mapDispatchToProps)(GlobalBody);
