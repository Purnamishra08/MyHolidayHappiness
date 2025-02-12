import React, {  useEffect,useState  } from 'react';
import { connect } from 'react-redux';
import GlobalBody from "../GlobalBody";
import { Radio, Button, Checkbox, Form, Input,Col, Row,Card , message, DatePicker, InputNumber,Upload,Select} from 'antd';
import API from "../../api/API";
import cookie from 'react-cookies';
import { useNavigate} from 'react-router-dom';
import { InboxOutlined, UploadOutlined, PlusOutlined,DeleteOutlined} from '@ant-design/icons';
import ReactQuill from 'react-quill';
import 'react-quill/dist/quill.snow.css';




export const AddCategory = (props) => {
       const navigate = useNavigate();
       

    const [sub_categories, setSubcategories] = useState(['']);    
    const [content, setContent] = useState('');
    const [loading, setLoading] = useState(false);
    useEffect(() => {
            const userDetails=cookie.load('userDetails');
               if(!userDetails){
               navigate(API.defaults.frontURL+'/login');
             }
        }, [cookie])
       const onFinish = (formData) => {
           const hide = message.loading('Loading', 0);
                formData.user_id=userDetails.id;
                formData.sub_categories=sub_categories;
              API.post('/saveCategory',formData)
                  .then(response=>{
                     setTimeout(hide, 0);
                    if(response.data.status){
                         navigate(API.defaults.frontURL+'/categories');
                      }else{
                          message.error('Error occurred');
                      }
                      
                  });

          }
        const handleSubCategoryChange = (index, event) => {
           let data = [...sub_categories];
           data[index]= event.target.value;
           setSubcategories(data);
        }
       const removeSubCategory = (index) => {
          let data = [...sub_categories];
          data.splice(index, 1);
          setSubcategories(data)
      }
       const onFinishFailed = (errorInfo) => {
            console.log('Failed:', errorInfo);
          };
     return (
              <>
                <GlobalBody>
                    <Row>
                      <Col span={20} offset={2}>
                        
                         <Card>
                           <h2 className="text-center">Add Category</h2>
                            <Form name="login" initialValues={{ remember: true}} onFinish={onFinish} onFinishFailed={onFinishFailed} autoComplete="off" >
                                 <Row>
                                   <Col  span={24} >
                                        <Form.Item labelCol={{span: 4}} wrapperCol={{span: 20}} label="Category" name="category" rules={[{ required: true, message: 'Category is required!' }]}  >
                                                <Input />
                                        </Form.Item>
                                    </Col>
                                    <Col  span={24} >
                                 
                                 
                                       {sub_categories.map((subCategory,index) => (
                                       
                                          <Row key={index}>       
                                          <Col span={12}>
                                              <Form.Item labelCol={{span: 8}} wrapperCol={{span: 16}}  label={"Sub Category - "+(index+1) }  rules={[{ required: true, message: "subCategory -"+(index+1)+" is required!" }]}  >
                                                    <Input  name="sub_categories[]"  value={subCategory} onChange={event => handleSubCategoryChange(index, event)}  />
                                              </Form.Item>
                                          </Col>
                                           <Col span={4}>
                                                <DeleteOutlined   style={{'padding':'1%','color':'red','fontSize':'18px'}} onClick={() => removeSubCategory(index)}/>
                                            </Col>
                                            </Row>
                                       
                                         ))}
                                      
                           
                                 </Col>
                                 <Col span={16}  offset={4}>
                                      <Button type="primary" icon={<PlusOutlined style={{ color: "white", fontSize: "16px",verticalAlign: '1px'}} />}  size={'Default'} shape="round" onClick={()=>{setSubcategories(sub_categories => [...sub_categories, ''])}}>Add SubCategory</Button>
                                  </Col>
                                </Row>
                                <Form.Item wrapperCol={{offset: 6,span: 18}}
                                >
                                  <Button type="primary" htmlType="submit" className="float-end"  size={'Default'} shape="round">
                                    Submit
                                  </Button>
                                </Form.Item>
                              </Form>
                          </Card>
                      </Col>
                    </Row>
                     
                </GlobalBody>
              </>
          
      )
}

const mapStateToProps = (state) => ({})

export default connect(mapStateToProps, {})(AddCategory)