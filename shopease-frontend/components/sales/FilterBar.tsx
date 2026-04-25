"use client";

import { useRouter, usePathname, useSearchParams } from "next/navigation";
import { useState, useEffect } from "react";
import { SaleFilters } from "@/lib/types";
import { Search, Filter, RotateCcw } from "lucide-react";

interface Props {
  filters: SaleFilters;
}

const branches = ["Mirpur", "Gulshan", "Dhanmondi", "Uttara", "Motijheel", "Chattogram"];
const categories = ["Grocery", "Personal Care", "Beverages", "Dairy", "Cooking Essentials", "Snacks"];
const payments = ["Cash", "bKash", "Nagad", "Card"];

export default function FilterBar({ filters }: Props) {
  const router = useRouter();
  const pathname = usePathname();
  const searchParams = useSearchParams();
  
  const [localFilters, setLocalFilters] = useState(filters);

  useEffect(() => {
    setLocalFilters(filters);
  }, [filters]);

  const handleChange = (e: React.ChangeEvent<HTMLSelectElement | HTMLInputElement>) => {
    setLocalFilters(prev => ({ ...prev, [e.target.name]: e.target.value }));
  };

  const applyFilters = () => {
    const params = new URLSearchParams(searchParams.toString());
    Object.entries(localFilters).forEach(([key, value]) => {
      if (value) params.set(key, value);
      else params.delete(key);
    });
    params.set("page", "1");
    router.push(`${pathname}?${params.toString()}`);
  };

  const clearFilters = () => {
    setLocalFilters({});
    router.push(pathname);
  };

  return (
    <div className="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 space-y-4">
      <div className="flex items-center gap-2 text-slate-900 font-bold mb-2">
        <Filter className="w-5 h-5 text-blue-500" />
        <h2>Filter Sales</h2>
      </div>

      <div className="grid grid-cols-1 md:grid-cols-5 gap-4">
        <div className="space-y-1">
          <label className="text-xs font-bold text-slate-500 uppercase tracking-wider">Branch</label>
          <select 
            name="branch" 
            value={localFilters.branch || ""} 
            onChange={handleChange}
            className="w-full bg-slate-50 border-slate-200 rounded-xl text-sm focus:ring-blue-500 focus:border-blue-500 p-2.5"
          >
            <option value="">All Branches</option>
            {branches.map(b => <option key={b} value={b}>{b}</option>)}
          </select>
        </div>

        <div className="space-y-1">
          <label className="text-xs font-bold text-slate-500 uppercase tracking-wider">Category</label>
          <select 
            name="category" 
            value={localFilters.category || ""} 
            onChange={handleChange}
            className="w-full bg-slate-50 border-slate-200 rounded-xl text-sm focus:ring-blue-500 focus:border-blue-500 p-2.5"
          >
            <option value="">All Categories</option>
            {categories.map(c => <option key={c} value={c}>{c}</option>)}
          </select>
        </div>

        <div className="space-y-1">
          <label className="text-xs font-bold text-slate-500 uppercase tracking-wider">Payment</label>
          <select 
            name="payment_method" 
            value={localFilters.payment_method || ""} 
            onChange={handleChange}
            className="w-full bg-slate-50 border-slate-200 rounded-xl text-sm focus:ring-blue-500 focus:border-blue-500 p-2.5"
          >
            <option value="">All Methods</option>
            {payments.map(p => <option key={p} value={p}>{p}</option>)}
          </select>
        </div>

        <div className="space-y-1">
          <label className="text-xs font-bold text-slate-500 uppercase tracking-wider">From Date</label>
          <input 
            type="date" 
            name="from" 
            value={localFilters.from || ""} 
            onChange={handleChange}
            className="w-full bg-slate-50 border-slate-200 rounded-xl text-sm focus:ring-blue-500 focus:border-blue-500 p-2.5" 
          />
        </div>

        <div className="space-y-1">
          <label className="text-xs font-bold text-slate-500 uppercase tracking-wider">To Date</label>
          <input 
            type="date" 
            name="to" 
            value={localFilters.to || ""} 
            onChange={handleChange}
            className="w-full bg-slate-50 border-slate-200 rounded-xl text-sm focus:ring-blue-500 focus:border-blue-500 p-2.5" 
          />
        </div>
      </div>

      <div className="flex justify-end gap-3 pt-2">
        <button 
          onClick={clearFilters}
          className="flex items-center gap-2 px-6 py-2.5 rounded-xl text-sm font-bold text-slate-500 hover:bg-slate-100 transition-colors"
        >
          <RotateCcw className="w-4 h-4" />
          Clear
        </button>
        <button 
          onClick={applyFilters}
          className="flex items-center gap-2 px-8 py-2.5 bg-blue-600 text-white rounded-xl text-sm font-bold hover:bg-blue-700 transition-all shadow-lg shadow-blue-200"
        >
          <Search className="w-4 h-4" />
          Apply Filters
        </button>
      </div>
    </div>
  );
}
