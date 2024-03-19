import React, {useState, useEffect} from 'react'
import ReactDOM from 'react-dom'
import axios from 'axios'

export default function DesktopCartComponent (props) {
    const [cartItems, setCartItems] = useState('')

    useEffect(() => {
        console.log(props)
        if (props.id) {
            axios.get(`/api/cart/${props.id}`)
            .then(response => {
                setCartItems(response.data.length +'')
            }).catch(function (thrown) {
                console.log(thrown)
            });
        }

    }, [])
    return (

        <a href="/cart" className="hidden md:flex items-center mr-4 relative hover:text-blue-500">
            <i
                className="cursor-pointer material-icons ml-2"
                style={{ fontSize: 36 }}>
                shopping_cart
            </i>
            <p className="absolute -top-2 -right-2 font-bold text-lg text-blue-700">{cartItems}</p>
        </a>
    )
}

if (document.getElementById('desktopCart')) {
    const element = document.getElementById('desktopCart')
    const props = Object.assign({}, element.dataset)
    ReactDOM.render(<DesktopCartComponent {...props} />, element)
}