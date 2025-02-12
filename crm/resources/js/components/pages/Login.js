import React, {  useEffect  } from 'react';
import { connect } from 'react-redux';
import LoginBody from "./LoginBody";
import { Button, Checkbox, Form, Input,Col, Row,Card , message} from 'antd';
import API from "../api/API";
import cookie from 'react-cookies';
import { useNavigate} from 'react-router-dom';




export const Login = (props) => {
       const navigate = useNavigate();
       
       useEffect(() => {
          //cookie.remove('userDetails');
         const userDetails=cookie.load('userDetails');
         if(userDetails){
           navigate(API.defaults.frontURL+'/blogs');
         }
        }, [cookie])


       const onFinish = (formData) => {
           const hide = message.loading('Loading', 0);
              API.post('/tryLogin',formData)
                  .then(response=>{
                     setTimeout(hide, 0);
                    if(response.data.status){
                        API.post('/getUserDetails',{'id':response.data.userId}).then(response=>{
                           cookie.save('userDetails', response.data.user_details);
                           //this.props.history.push('/dashboard'); 
                           navigate(API.defaults.frontURL+'/blogs');

                        });
                      }else{
                          message.error('Invalid email or password');
                      }
                      
                  });

          };
       const onFinishFailed = (errorInfo) => {
            console.log('Failed:', errorInfo);
          };
     return (
              <>
                <LoginBody>
                    <Row>
                      <Col span={12} offset={6}>
                        
                         <Card>
                           <h2 className="text-center">Login</h2>
                             <Form name="login" labelCol={{span: 6}} wrapperCol={{span: 16}} initialValues={{ remember: true}} onFinish={onFinish} onFinishFailed={onFinishFailed} autoComplete="off">
                                <Form.Item label="Email" name="email" rules={[ { required: true, message: 'Please input your email!' }]}  >
                                  <Input />
                                </Form.Item>

                                <Form.Item label="Password" name="password" rules={[ { required: true, message: 'Please input your password!' }]}>
                                  <Input.Password />
                                </Form.Item>

                                <Form.Item wrapperCol={{offset: 6,span: 16}}
                                >
                                  <Button type="primary" htmlType="submit" className="float-end"  size={'Default'} shape="round">
                                    Submit
                                  </Button>
                                </Form.Item>
                              </Form>
                          </Card>
                      </Col>
                    </Row>
                     
                </LoginBody>
              </>
          
      )
}

const mapStateToProps = (state) => ({})

export default connect(mapStateToProps, {})(Login)