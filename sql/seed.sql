USE saarr_modesty;

-- CATEGORIES (vaste 5)
INSERT INTO categories (slug, name_nl, name_en) VALUES
('abaya', 'Abaya', 'Abaya'),
('khimaar', 'Khimaar', 'Khimaar'),
('hijab', 'Hijab', 'Hijab'),
('sets', 'Sets', 'Sets'),
('accessoires', 'Accessoires', 'Accessories');

-- PRODUCTS (demo)
INSERT INTO products (category_id, sku, name_nl, name_en, description_nl, description_en, price, is_active)
VALUES
((SELECT id FROM categories WHERE slug='abaya'), 'ABY-001', 'Zwarte Abaya Classic', 'Black Abaya Classic',
 'Elegante abaya voor dagelijks gebruik.', 'Elegant abaya for daily wear.', 49.99, 1),

((SELECT id FROM categories WHERE slug='hijab'), 'HIJ-001', 'Jersey Hijab Sand', 'Jersey Hijab Sand',
 'Zachte jersey hijab met comfortabele stretch.', 'Soft jersey hijab with comfortable stretch.', 14.99, 1),

((SELECT id FROM categories WHERE slug='sets'), 'SET-001', '2-delige Set Beige', '2-piece Set Beige',
 'Moderne set voor een complete look.', 'Modern set for a complete look.', 59.99, 1);

-- PRODUCT IMAGES (paths zijn placeholders)
INSERT INTO product_images (product_id, image_path, alt_nl, alt_en, sort_order)
VALUES
((SELECT id FROM products WHERE sku='ABY-001'), 'assets/img/abaya1.jpg', 'Zwarte abaya', 'Black abaya', 0),
((SELECT id FROM products WHERE sku='HIJ-001'), 'assets/img/hijab1.jpg', 'Jersey hijab', 'Jersey hijab', 0),
((SELECT id FROM products WHERE sku='SET-001'), 'assets/img/set1.jpg', 'Beige set', 'Beige set', 0);

-- VARIANTS (maat/kleur/voorraad)
INSERT INTO variants (product_id, size, color, stock, sku_variant, is_active)
VALUES
((SELECT id FROM products WHERE sku='ABY-001'), 'S', 'Black', 5, 'ABY-001-S-BLK', 1),
((SELECT id FROM products WHERE sku='ABY-001'), 'M', 'Black', 3, 'ABY-001-M-BLK', 1),
((SELECT id FROM products WHERE sku='ABY-001'), 'L', 'Black', 0, 'ABY-001-L-BLK', 1),

((SELECT id FROM products WHERE sku='HIJ-001'), 'One Size', 'Sand', 10, 'HIJ-001-OS-SND', 1),

((SELECT id FROM products WHERE sku='SET-001'), 'M', 'Beige', 4, 'SET-001-M-BEI', 1),
((SELECT id FROM products WHERE sku='SET-001'), 'L', 'Beige', 2, 'SET-001-L-BEI', 1);

