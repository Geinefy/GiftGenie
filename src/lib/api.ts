import axios, { AxiosInstance } from "axios";

export interface Post {
  id: number;
  title: string;
  body: string;
  created_at?: string;
  updated_at?: string;
}

const api: AxiosInstance = axios.create({
  baseURL: `${import.meta.env.VITE_API_URL}/api`,
  // withCredentials: true, // (Sanctum/cookies লাগলে)
});

// ছোট হেল্পার: টাইপসহ ডেটা রিটার্ন
export const getPosts = async () => {
  const res = await api.get<Post[]>("/posts");
  return res.data;
};

export const createPost = async (payload: Pick<Post, "title" | "body">) => {
  const res = await api.post<Post>("/posts", payload);
  return res.data;
};

export default api;
