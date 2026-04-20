export default function ServiceCategory({ category, isOpen, onToggle }) {
  return (
    <div className="service-category">
      <div className="category-header" onClick={onToggle}>
        <span>{category.category}</span>
        <span className={`arrow ${isOpen ? 'rotated' : ''}`}>▶</span>
      </div>
      <ul className={`service-list ${isOpen ? 'open' : ''}`}>
        {category.items.map((item) => (
          <li key={item.name}>
            <span>{item.name}</span>
            <span>{item.price}</span>
          </li>
        ))}
      </ul>
    </div>
  )
}