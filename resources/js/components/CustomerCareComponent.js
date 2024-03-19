import React, {useState, useEffect, useRef} from 'react'
import ReactDOM from 'react-dom'
import axios from 'axios'

export default function CustomerCareComponent(props) {
    const [readyModal, setReadyModal] = useState(false)
    const [showModal, setShowModal] = useState(false)
    const [messages, setMessages] = useState([])
    const [message, setMessage] = useState('')
    const inputRef = useRef(null)

    useEffect(() => {
        axios.get('/api/chat/'+ props.id, {
            'user_id': props.id,
            sender: 'user',
            message
        })
        .then(response => {
            setMessages(response.data)
        })

        Echo.private('chat')
            .listen('MessageSent', (e) => {
                console.log('recieved')
                setMessages([...messages, e.chat])
            });
    }, [])

    useEffect(() => {
        if (readyModal && !showModal) {
            setShowModal(true)
            inputRef.current && inputRef.current.focus()
        }
    }, [readyModal])

    useEffect (() => {
        if (readyModal && !showModal) {
            setTimeout(() => setReadyModal(false), 500)
        }
    }, [showModal])

    useEffect (() => {
        if (message == '') {
            let div = document.getElementsByClassName('message')
            if (div.length > 0) {
                div = div[div.length - 1]
                div.scrollIntoView({ behavior: 'smooth' })
            }
        }
    }, [messages])

    const sendMessage = () => {
        let item = message
        item.trim()
        if (message.trim() == '') return 
        axios.post('/api/chat', {
            'user_id': props.id,
            sender: 'user',
            message
        })
        .then(response => {
            console.log(response.data);

        })
        .catch(response => {
            console.log(response)
        });
        setMessage('')
        setMessages([...messages, {sender: 'user', message}])
    }

    return (
        <div>
            <div 
                onClick={() => setReadyModal(true)} 
                className="cursor-pointer transition duration-500 ease-in-out transform hover:-translate-y-1 hover:scale-105 w-20 h-20 flex items-center justify-center bg-blue-500" 
                style={{ borderRadius: 50 }}
            >
                <i
                    className="material-icons text-white"
                    style={{ fontSize: 36 }}>
                    chat
                </i>
            </div>
            <div className={`${readyModal ? 'flex flex-col items-center justify-center fixed top-0 right-0 left-0 bottom-0 bg-black bg-opacity-25' : 'hidden'}`}>
                <div 
                    className={`bg-gray-200 flex flex-col items-center rounded shadow h-4/5 w-2/5 opacity-0 bg-white transition duration-500 ease-in-out ${showModal ? 'opacity-100 translate-y-4' : ''}`}
                    // style={{height: '80%'}}
                >
                    {readyModal && 
                        <>
                            <div className="bg-blue-600 w-full flex justify-between items center border-b border-gray-200 px-6 py-2">
                                <p className="text-3xl text-white">Customer Care</p>
                                <div onClick={() => setShowModal(false)}
                                    className="text-white cursor-pointer py-1 inline-block text-center px-3 border border-transparent rounded-md font-semibold hover:text-white text-xl uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    X
                                </div>
                            </div>
                            <div className="flex-1 overflow-y-auto w-full px-2 my-2">
                                {
                                    messages.length > 0 ?
                                        messages.map((item, i) => 
                                            <div 
                                                key={i} 
                                                className={`message m-2 flex ${item.sender == 'admin' ? 'justify-start': 'justify-end'}`}
                                            >
                                                <div 
                                                    className={`px-4 py-2 text-lg text-white ${item.sender == 'admin' ? 'rounded-r-lg rounded-tl-lg': 'rounded-l-lg rounded-tr-lg'} bg-blue-500`}
                                                    style={{ maxWidth: '60%' }}
                                                >
                                                    {item.message}
                                                </div>
                                            </div>
                                        )
                                        : <div></div>
                                }
                            </div>
                            <div className="w-full flex">
                                <input
                                    ref={inputRef}
                                    type="text"
                                    placeholder="Start typing..."
                                    className={`flex-1 `}
                                    value={message}
                                    onKeyPress={e => e.key == 'Enter' && sendMessage()}
                                    onChange={e => setMessage(e.target.value)}
                                />
                                <div 
                                    onClick={() => sendMessage()} 
                                    className="cursor-pointer transition duration-200 transform hover:bg-blue-800 bg-blue-600 w-1/4 h-16 py-2 flex items-center justify-center"
                                >
                                    <p className="font-bold text-white text-center">Send Message</p>
                                </div>
                            </div>
                        </>
                    }
                </div>
            </div>
        </div>
    )
}

if (document.getElementById('customerCare')) {
    const element = document.getElementById("customerCare")
    const props = Object.assign({}, element.dataset)
    ReactDOM.render(<CustomerCareComponent {...props} />, element)
}
