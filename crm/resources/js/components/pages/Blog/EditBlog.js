import React, {  useEffect,useState  } from 'react';
import { connect } from 'react-redux';
import GlobalBody from "../GlobalBody";
import { Radio, Button, Checkbox, Form, Input,Col, Row,Card , message, DatePicker, InputNumber,Upload,Select} from 'antd';
import API from "../../api/API";
import cookie from 'react-cookies';
import { useNavigate ,useSearchParams} from 'react-router-dom';
import { InboxOutlined, UploadOutlined, PlusOutlined,DeleteOutlined} from '@ant-design/icons';
import ReactQuill from 'react-quill';
import 'react-quill/dist/quill.snow.css';




export const EditBlog = (props) => {
       const navigate = useNavigate();   
      const [form] = Form.useForm();
    const [params, setParams] = useSearchParams();
     const [fileList, setFileList] = useState([ ]);
        var formDisabled = false;

    const uploadURL=API.defaults.baseURL+"uploadTempBlogImage";
    const [content, setContent] = useState('');
    const [blogDetails, setBlogDetails] = useState(false);

    const [loading, setLoading] = useState(false);
    const [categories, setCategories]= useState([]);
    const [sub_categories, setSubCategories]= useState([]);
    const [filtered_subcategories, setFilteredSubCategories ] = useState([]);
      const handleCategoryChange = (value) => {
           
            if(value){
                setFilteredSubCategories(sub_categories.filter((scategory)=>scategory.category_id==value)); 
            }else{
                setFilteredSubCategories([]);  
            }
            
    }
       useEffect(() => {
         const userDetails=cookie.load('userDetails');
           if(!userDetails){
           navigate(API.defaults.frontURL+'/login');
         }
         setLoading(true);
        formDisabled=true;
        const hide = message.loading('Loading', 0);
        API.post('/getBlogDetailsForEdit',{'id':params.get("id"),'user_id':userDetails.id})
              .then(response=>{
                 formDisabled=false; 
                setTimeout(hide, 0);

                if(response.data.status){
                      setCategories(response.data.categories.map(row => ({
                                  key: row.id,
                                  id: row.id,
                                  category: row.category
                                }))); 
                        setSubCategories(response.data.sub_categories);  
                    let tempBlogDetails=response.data.blog_details;
                   
                        tempBlogDetails.image_file=[];
                       // console.log(tempBlogDetails.blogImage);
                     if(tempBlogDetails.blogImage){
                           tempBlogDetails.image_file=[{'name':tempBlogDetails.blogImage,'url':API.defaults.uploadURL+'/'+tempBlogDetails.blogImage}];
                        setFileList(tempBlogDetails.image_file);
                      }
                      
                       console.log(tempBlogDetails);
                      setBlogDetails(tempBlogDetails);
                        form.setFieldsValue(response.data.blog_details);
                        setLoading(false);
               }
                  
              });
        }, [cookie])
        const normFile = (e) => {
              console.log('Upload event:', e);

              if (Array.isArray(e)) {
                return e;
              }

              return e?.fileList;
            };
      const uploadDraggerChange=(e)=>{
          if(e.fileList.length && e.fileList[0].response){
             API.post('/updateBlogImage',{'id':params.get("id"),'filenametostore':e.fileList[0].response.filenametostore,'originalFileName':e.fileList[0].response.originalFileName  }).then(response=>{});
        }
      }
       const onFinish = (formData) => {
           const hide = message.loading('Loading', 0);
               formData.id=params.get("id");
               console.log(formData);
              API.post('/updateBlog',formData)
                  .then(response=>{
                     setTimeout(hide, 0);
                    if(response.data.status){
                         navigate(API.defaults.frontURL+'/blogs');
                      }else{
                          message.error('Error occurred');
                      }
                      
                  });

          };
       const onFinishFailed = (errorInfo) => {
            console.log('Failed:', errorInfo);
          };
     return (
              <>
                <GlobalBody>
                    <Row>
                      <Col span={20} offset={2}>
                        
                         <Card>
                           <h2 className="text-center">Edit Blog</h2>
                            <Form  form={form} disabled={formDisabled}  name="login" initialValues={{ remember: true}} onFinish={onFinish} onFinishFailed={onFinishFailed} autoComplete="off" >
                                 <Row>
                                    <Col  span={24} >
                                        <Form.Item labelCol={{span: 4}} wrapperCol={{span: 20}} label="Title" name="title" rules={[{ required: true, message: 'Title is required!' }]}  >
                                                <Input />
                                        </Form.Item>
                                    </Col>
                                    <Col span={24} >
                                      <Form.Item  label="Summary"  name="summary"  labelCol={{span: 4}} wrapperCol={{span: 20}} rules={[ { required: true, message: 'Summary is required!' }]}>
                                          <Input.TextArea rows="10" />
                                      </Form.Item>
                                    </Col>
                                    <Col span={24} style={{'height':'250px'}} >
                                      <Form.Item label="Content"  name="content" labelCol={{span: 4}} wrapperCol={{span: 20}} rules={[ { required: true, message: 'Content is required!' }]}>
                                           <ReactQuill theme="snow" value={content} onChange={setContent} style={{'height':'200px'}} />
                                      </Form.Item>
                                    </Col>
                                    <Col  span={24} >
                                        <Form.Item label="Category" name="category" labelCol={{span: 4}} wrapperCol={{span: 20}} rules={[ { required: true, message: 'Category is required!' }]}  >
                                            <Select placeholder="Select Category"  onChange={event => handleCategoryChange( event)}  allowClear  >
                                              {categories.map((category) => (
                                                         <Select.Option key={category.id} value={category.id}>{category.category}</Select.Option>
                                               ))}
                                            
                                            </Select>
                                        </Form.Item>
                                      </Col>
                                      <Col  span={24} >
                                        <Form.Item label="Sub Category" name="sub_categories" labelCol={{span: 4}} wrapperCol={{span: 20}} rules={[ { required: true, message: 'Sub Category is required!' }]}  >
                                            <Select placeholder="Select Sub Category"  mode="multiple"  allowClear>
                                              {filtered_subcategories.map((category) => (
                                                        <Select.Option key={category.id} value={category.subcategory}>{category.subcategory}</Select.Option>
                                               ))}
                                            
                                            </Select>
                                        </Form.Item>
                                      </Col>
                                     <Col span={20} offset={4}  >
                                   
                                        <Form.Item label=""  wrapperCol={{span: 24}}>
                                        <Form.Item name="image_file" valuePropName="fileList" getValueFromEvent={normFile} noStyle >
                                          <Upload.Dragger name="files" action={uploadURL} listType="picture"  maxCount={1}  onChange={event => uploadDraggerChange(event)}>
                                            <p className="ant-upload-drag-icon">
                                              <InboxOutlined />
                                            </p>
                                            <p className="ant-upload-text">Click or drag image to this area to upload</p>
                                          </Upload.Dragger>
                                        </Form.Item>
                                      </Form.Item>

                                  </Col>
                                </Row>
                                <Form.Item wrapperCol={{offset: 6,span: 18}}
                                >
                                  <Button type="primary" htmlType="submit" className="float-end"  size={'Default'} shape="round">
                                    Update
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

export default connect(mapStateToProps, {})(EditBlog)