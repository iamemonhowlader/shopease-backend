
import csv
import random
import uuid
from datetime import datetime, timedelta

#configuration
TOTAL_ROWS      = 20_000
DUPLICATE_COUNT = 200       # ~200 duplicate sale_ids
OUTPUT_FILE     = "shopease_dirty.csv"
RANDOM_SEED     = 42
random.seed(RANDOM_SEED)

# branch name 
BRANCH_VARIANTS = {
    "Mirpur":      ["mirpur", "Mirpur ", "MIRPUR"],
    "Gulshan":     ["gulshan", "Gulshan ", "GULSHAN"],
    "Dhanmondi":   ["dhanmondi", "Dhanmondi ", "DHANMONDI"],
    "Uttara":      ["uttara", "Uttara ", "UTTARA"],
    "Motijheel":   ["motijheel", "Motijheel ", "MOTIJHEEL"],
    "Chattogram":  ["chattogram", "Chattogram ", "CHATTOGRAM"],
}
ALL_BRANCH_VARIANTS = [v for variants in BRANCH_VARIANTS.values() for v in variants]

# Products (mix of English + Bengali)

PRODUCTS = [
    "Rice (Premium)", "Wheat Flour", "Cooking Oil", "Sugar",
    "Dal (Masoor)", "Dal (Moong)", "Salt", "Tea Leaves",
    "Biscuits (Pack)", "Noodles", "Soap Bar", "Shampoo",
    "Detergent Powder", "Toothpaste", "Baby Powder",
    "চিনি",        # Sugar in Bengali
    "আটা",         # Flour in Bengali
    "  Rice Bran Oil  ",   # leading/trailing spaces
    "  Sugar (Fine) ",
    "Mustard Oil", "Ghee", "Condensed Milk", "Powdered Milk",
    "Cornflour", "Baking Soda", "Vinegar", "Soy Sauce",
]

# Categories 
CATEGORY_POOL = [
    "Grocery", "Personal Care", "Beverages", "Dairy",
    "Cooking Essentials", "Snacks",
    "",       # blank
    "N/A",    # should become NULL
    "-",      # should become NULL
    "n/a",
]

# Payment methods variable

PAYMENT_VARIANTS = [
    "cash", "Cash", "CASH",
    "bKash", "bkash", "BKASH",
    "nagad", "Nagad", "NAGAD",
    "card", "Card",
]

# Salespersons Name
SALESPERSONS = [
    "Rahim Uddin", "Karim Sheikh", "Nusrat Jahan", "Farhan Hossain",
    "Sumaiya Begum", "Tanvir Ahmed", "Riya Akter", "Milon Chandra",
    "Sabbir Rahman", "Dilruba Khanam",
]


# HELPER FUNCTIONS

def random_date(start_year=2022, end_year=2024):
    """Return a date in one of 3 dirty formats."""
    start = datetime(start_year, 1, 1)
    end   = datetime(end_year, 12, 31)
    delta = end - start
    rand_date = start + timedelta(days=random.randint(0, delta.days))

    fmt_choice = random.randint(0, 2)
    if fmt_choice == 0:
        return rand_date.strftime("%d/%m/%Y")   # d/m/Y  → 25/07/2023
    elif fmt_choice == 1:
        return rand_date.strftime("%Y-%m-%d")   # Y-m-d  → 2023-07-25
    else:
        return rand_date.strftime("%m-%d-%Y")   # m-d-Y  → 07-25-2023


def dirty_unit_price():
    """Return price as plain float OR with ৳ and comma formatting."""
    base_price = round(random.uniform(50, 5000), 2)
    style = random.randint(0, 2)
    if style == 0:
        return str(base_price)                          # 1200.0
    elif style == 1:
        return f"৳{base_price:,.2f}"                   # ৳1,200.00
    else:
        return f"৳{base_price:.2f}"                    # ৳1200.00


def dirty_discount():
    """Return discount as 10 | '10%' | 0.10 — all mean 10%."""
    pct_value = random.choice([0, 5, 10, 15, 20, 25])
    style = random.randint(0, 2)
    if style == 0:
        return str(pct_value)                           # 10
    elif style == 1:
        return f"{pct_value}%"                          # 10%
    else:
        return str(round(pct_value / 100, 2))           # 0.10


def maybe_missing_salesperson():
    """90% of the time return a name, 10% return empty string (missing)."""
    if random.random() < 0.10:
        return ""           # missing — will be set to 'Unknown' on import
    return random.choice(SALESPERSONS)



# generate rows

print(f"[INFO] Generating {TOTAL_ROWS} rows...")

rows = []
unique_ids = [str(uuid.uuid4())[:12].upper() for _ in range(TOTAL_ROWS)]

# Pick ~200 IDs that will be duplicated later
duplicate_ids = random.sample(unique_ids, DUPLICATE_COUNT)

for i, sale_id in enumerate(unique_ids):
    row = {
        "sale_id":        sale_id,
        "branch":         random.choice(ALL_BRANCH_VARIANTS),
        "sale_date":      random_date(),
        "product_name":   random.choice(PRODUCTS),
        "category":       random.choice(CATEGORY_POOL),
        "quantity":       random.randint(1, 100),
        "unit_price":     dirty_unit_price(),
        "discount_pct":   dirty_discount(),
        "payment_method": random.choice(PAYMENT_VARIANTS),
        "salesperson":    maybe_missing_salesperson(),
    }
    rows.append(row)


# INJECT ~200 DUPLICATES

print(f"[INFO] Injecting {DUPLICATE_COUNT} duplicate rows...")

duplicate_rows = []
for dup_id in duplicate_ids:
    # Find the original row and copy it (slight variation allowed)
    original = next(r for r in rows if r["sale_id"] == dup_id)
    duplicate_rows.append(original.copy())

# Shuffle duplicates into the dataset at random positions
for dup_row in duplicate_rows:
    insert_pos = random.randint(0, len(rows))
    rows.insert(insert_pos, dup_row)

print(f"[INFO] Total rows (including duplicates): {len(rows)}")


# WRITE CSV
FIELDNAMES = [
    "sale_id", "branch", "sale_date", "product_name",
    "category", "quantity", "unit_price", "discount_pct",
    "payment_method", "salesperson",
]

print(f"[INFO] Writing to {OUTPUT_FILE}...")

# UTF-8 BOM so Excel opens Bengali chars correctly
with open(OUTPUT_FILE, "w", newline="", encoding="utf-8-sig") as f:
    writer = csv.DictWriter(f, fieldnames=FIELDNAMES)
    writer.writeheader()
    writer.writerows(rows)


# SUMMARY REPORT

print("\n" + "="*50)
print("  CSV Generation Complete!")
print("="*50)
print(f"  Output file   : {OUTPUT_FILE}")
print(f"  Total rows    : {len(rows):,}")
print(f"  Unique IDs    : {TOTAL_ROWS:,}")
print(f"  Duplicates    : {DUPLICATE_COUNT}")
print(f"  Missing sales : ~{int(TOTAL_ROWS * 0.10):,} rows (salesperson='')")
print("="*50)
print("\nDirty variants baked in:")
print("  branch       → 3 case variants per branch")
print("  sale_date    → d/m/Y | Y-m-d | m-d-Y")
print("  unit_price   → plain | ৳X,XXX.XX | ৳XXXX.XX")
print("  discount_pct → 10 | '10%' | 0.10")
print("  payment      → cash/Cash/CASH, bKash/bkash/BKASH, etc.")
print("  category     → blank | N/A | - | n/a (→ NULL on import)")
print("  salesperson  → ~10% rows empty (→ 'Unknown' on import)")
print("  product_name → some Bengali script, some with spaces")