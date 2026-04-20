import { Link } from 'react-router-dom'
import logo from '../assets/logo.png'

export default function Navbar() {
  return (
    <div id="main-navbar">
      <div id="nav-logo">
        <img src={logo} alt="Golden Mane logo" height="128" width="128" />
      </div>
      <ul id="nav-links">
        <li><Link to="/">HOME</Link></li>
        <li><Link to="/services">SERVICES</Link></li>
        <li><Link to="/staff">STAFF</Link></li>
        <li><Link to="/about">ABOUT</Link></li>
        <li><Link to="/gift-cards">GIFT-CARDS</Link></li>
        <li><Link to="/reviews">REVIEWS</Link></li>
      </ul>
    </div>
  )
}